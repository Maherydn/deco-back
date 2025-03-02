<?php

namespace App\Controller\api\orders;

use App\Repository\OrdersRepository;
use App\Service\OrdersStatisticsService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api/orders-statistics", name: "orders.")]
final class OrdersStatisticsController extends AbstractController
{
    public function __construct(private OrdersRepository $ordersRepository) {}

    #[Route("/{product}", name: "product", methods: ["GET"])]
    public function getSumByMonth(
        string $product,
        OrdersStatisticsService $ordersStatisticsService
    ): JsonResponse {
        $products = [
            "cake" => 1,
            "chocolate" => 2,
        ];

        if (!array_key_exists($product, $products)) {
            return $this->json(
                ["error" => "Produit non trouvé"],
                Response::HTTP_NOT_FOUND
            );
        }

        $total = $this->ordersRepository->getMonthlyTotalsByProduct(
            2025,
            $products[$product]
        );

        $data = $ordersStatisticsService->formatMonthlyOrders($total);

        return $this->json(
            $data,
            Response::HTTP_OK,
            [],
            ["groups" => ["orders"]]
        );
    }
}
