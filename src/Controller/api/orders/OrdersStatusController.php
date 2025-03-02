<?php

namespace App\Controller\api\orders;

use App\Entity\Orders;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/orders-status", name: "orders.")]
final class OrdersStatusController extends AbstractController
{
    #[Route("/ready/{id}", name: "status_ready", methods: ["PATCH"])]
    public function statusReady(
        Orders $orders,
        StatusRepository $statusRepository,
        EntityManagerInterface $em
    ): JsonResponse {
        $status = $statusRepository->find(2); //id status ready

        if (!$status) {
            return $this->json(
                ["error" => "Statut introuvable"],
                Response::HTTP_NOT_FOUND
            );
        }

        $orders->setStatu($status);
        $em->flush();

        return $this->json(
            [
                "message" => "Statut mis à jour en 'ready' avec succès",
                "orders" => $orders,
            ],
            Response::HTTP_OK,
            [],
            ["groups" => ["orders"]]
        );
    }
}
