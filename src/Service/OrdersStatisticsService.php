<?php

namespace App\Service;

class OrdersStatisticsService
{
    public function formatMonthlyOrders(array $data): array
    {
        $ordersPerMonth = array_fill(0, 12, 0);

        foreach ($data as $entry) {
            $monthIndex = $entry["month"] - 1; 
            $ordersPerMonth[$monthIndex] = $entry["total_orders"];
        }

        return $ordersPerMonth;
    }
}
