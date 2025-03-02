<?php

namespace App\Entity;

use App\Repository\OrdersRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: OrdersRepository::class)]
class Orders
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(groups: ['orders'])]
    private ?int $id = null;

    #[Groups(['orders'])]
    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column]
    #[Groups(['orders'])]
    private ?\DateTimeImmutable $deliveryAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[Groups(['orders'])]
    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Status $statu = null;

    #[Groups(['orders'])]
    #[ORM\ManyToOne(inversedBy: 'orders')]
    private ?Products $product = null;

    #[Groups(['orders'])]
    #[ORM\Column(length: 255)]
    private ?string $customer = null;

    #[Groups(['orders'])]
    #[ORM\Column(length: 255)]
    private ?string $description = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getDeliveryAt(): ?\DateTimeImmutable
    {
        return $this->deliveryAt;
    }

    public function setDeliveryAt(\DateTimeImmutable $deliveryAt): static
    {
        $this->deliveryAt = $deliveryAt;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getStatu(): ?Status
    {
        return $this->statu;
    }

    public function setStatu(?Status $statu): static
    {
        $this->statu = $statu;

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getCustomer(): ?string
    {
        return $this->customer;
    }

    public function setCustomer(string $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}
