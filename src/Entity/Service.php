<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServiceRepository::class)]
class Service
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Le nom de la prestation ne peut pas être vide.')]
    #[Assert\Length(
        max: 100,
        maxMessage: 'Le nom de la prestation ne peut pas dépasser {{ limit }} caractères.'
    )]
    private ?string $name = null;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\Length(
        max: 1000,
        maxMessage: 'La description ne peut pas dépasser {{ limit }} caractères.'
    )]
    private ?string $description = null;

    #[ORM\Column(type: 'decimal', precision: 8, scale: 2)]
    #[Assert\NotBlank(message: 'Le prix est requis.')]
    #[Assert\PositiveOrZero(message: 'Le prix doit être positif ou nul.')]
    private ?string $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Retourne le prix sous forme de chaîne, ex. "49.99"
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * Définit le prix. Doit être formaté "0.00"
     */
    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }
}
