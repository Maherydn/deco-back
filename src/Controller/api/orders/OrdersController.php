<?php

namespace App\Controller\api\orders;

use App\DTO\OrdersCreateDTO;
use App\DTO\OrdersUpdateDTO;
use App\Entity\Orders;
use App\Repository\OrdersRepository;
use App\Repository\StatusRepository;
use App\Service\OrdersService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route("/api/orders", name: "orders.")]
final class OrdersController extends AbstractController
{
    #[Route("", name: "index", methods: ["GET"])]
    public function index(OrdersRepository $ordersRepository): JsonResponse
    {
        $orders = $ordersRepository->findAll();

        return $this->json(
            $orders,
            Response::HTTP_OK,
            [],
            ["groups" => ["orders"]]
        );
    }

    #[Route("/{id}", name: "show", methods: ["GET"])]
    public function show(Orders $order): JsonResponse
    {

        return $this->json(
            $order,
            Response::HTTP_OK,
            [],
            ["groups" => ["orders"]]
        );
    }

    #[Route("/new", name: "new", methods: ["POST"])]
    public function new(
        EntityManagerInterface $em,
        #[MapRequestPayload] OrdersCreateDTO $ordersCreateDTO,
        OrdersService $ordersService,
        StatusRepository $statusRepository
    ): Response {
        $orders = $ordersService->createOrdersFromDTO($ordersCreateDTO);
        $orders->setCreatedAt(new \DateTimeImmutable());
        $statu = $statusRepository->find(1);
        $orders->setStatu($statu);

        $em->persist($orders);
        $em->flush();

        return $this->json(
            [
                "message" => "Commande créée avec succès",
                "orders" => $orders,
            ],
            Response::HTTP_CREATED,
            [],
            ["groups" => ["recruiter.show"]]
        );
    }

    #[Route("/update/{id}", name: "update", methods: ["PATCH"])]
    public function update(
        Orders $orders,
        EntityManagerInterface $em,
        #[MapRequestPayload] OrdersUpdateDTO $ordersUpdateDTO,
        OrdersService $ordersService
    ): Response {
        $ordersService->updateOrdersFromDTO($orders, $ordersUpdateDTO);
        $em->flush();

        return $this->json(
            [
                "message" => "Commande mise à jour avec succès",
                "orders" => $orders,
            ],
            Response::HTTP_OK,
            [],
            ["groups" => ["recruiter.show"]]
        );
    }

    
}
