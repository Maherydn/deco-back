<?php

namespace App\Service;

use App\DTO\OrdersCreateDTO;
use App\DTO\OrdersUpdateDTO;
use App\Entity\Orders;
use App\Repository\ProductsRepository;
use App\Repository\StatusRepository;

class OrdersService
{
    private ProductsRepository $productsRepository;

    public function __construct(StatusRepository $statusRepository, ProductsRepository $productsRepository)
    {
        $this->productsRepository = $productsRepository;
    }

    public function createOrdersFromDTO(OrdersCreateDTO $ordersCreateDTO): Orders
    {
        return $this->mapDTOToOrders(new Orders(), $ordersCreateDTO);
    }

    public function updateOrdersFromDTO(Orders $orders, OrdersUpdateDTO $ordersUpdateDTO): Orders
    {
        return $this->mapDTOToOrders($orders, $ordersUpdateDTO);
    }

    private function mapDTOToOrders(Orders $orders, object $dto): Orders
    {
        $repositories = [
            "product" => $this->productsRepository,
        ];

        $properties = [
            "price" => "setPrice",
            "deliveryAt" => "setDeliveryAt",
            "description" => "setDescription",
            "customer" => "setCustomer",
            "product" => "setProduct",
        ];

        foreach ($properties as $prop => $setter) {
            if (!property_exists($dto, $prop)) {
                continue;
            }

            $value = $dto->$prop;

            if (isset($repositories[$prop]) && $value !== null) {
                $entity = $repositories[$prop]->find($value);
                $orders->$setter($entity);
            } elseif ($value !== null && $value !== "") {
                $orders->$setter($value);
            }
        }

        return $orders;
    }
}
