<?php

namespace App\DTO;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class OrdersUpdateDTO
{
    public function __construct(
        #[Assert\Type("integer")] public readonly ?int $price,

        #[
            Assert\Type(\DateTimeImmutable::class)
        ]
        public readonly ?DateTimeImmutable $deliveryAt,

        #[Assert\Type("integer")] public readonly ?int $product,

        #[Assert\Type("string")] public readonly ?string $customer,

        #[Assert\Type("string")] public readonly ?string $description
    ) {}
}
