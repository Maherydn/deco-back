<?php

namespace App\DTO;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class OrdersCreateDTO
{
    public function __construct(
        #[Assert\NotBlank] #[
            Assert\Type("integer")
        ]
        public readonly ?int $price,

        #[Assert\NotBlank] #[
            Assert\Type("string")
        ]
        public readonly ?string $description,

        #[Assert\NotBlank] #[
            Assert\Type(\DateTimeImmutable::class)
        ]
        public readonly ?DateTimeImmutable $deliveryAt,

        #[Assert\NotBlank] #[
            Assert\Type("integer")
        ]
        public readonly ?int $product,

        #[Assert\NotBlank] #[
            Assert\Type("string")
        ]
        public readonly ?string $customer
    ) {}
}
