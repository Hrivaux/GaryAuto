<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\AppointmentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AppointmentRepository::class)]
#[ORM\Table(name: 'appointment')]
class Appointment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Vehicle::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Vehicle $vehicle;

    #[ORM\ManyToOne(targetEntity: Service::class)]
    #[ORM\JoinColumn(nullable: false)]
    private Service $service;

    #[ORM\Column(type: 'string', length: 128)]
    #[Assert\NotBlank(message: 'Le nom du client est requis.')]
    private ?string $clientName = null;

    #[ORM\Column(type: 'string', length: 32)]
    #[Assert\NotBlank(message: 'Le téléphone du client est requis.')]
    #[Assert\Regex(
        pattern: '/^\+?[0-9 \-]+$/',
        message: 'Veuillez saisir un numéro de téléphone valide.'
    )]
    private ?string $clientPhone = null;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotNull(message: 'La date et l’heure du rendez-vous sont requises.')]
    private ?\DateTimeInterface $scheduledAt = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'string', length: 20)]
    #[Assert\Choice(
        choices: ['pending', 'confirmed', 'canceled'],
        message: 'Statut invalide.'
    )]
    private string $status = 'pending';

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVehicle(): Vehicle
    {
        return $this->vehicle;
    }

    public function setVehicle(Vehicle $vehicle): static
    {
        $this->vehicle = $vehicle;
        return $this;
    }

    public function getService(): Service
    {
        return $this->service;
    }

    public function setService(Service $service): static
    {
        $this->service = $service;
        return $this;
    }

    public function getClientName(): ?string
    {
        return $this->clientName;
    }

    public function setClientName(string $clientName): static
    {
        $this->clientName = $clientName;
        return $this;
    }

    public function getClientPhone(): ?string
    {
        return $this->clientPhone;
    }

    public function setClientPhone(string $clientPhone): static
    {
        $this->clientPhone = $clientPhone;
        return $this;
    }

    public function getScheduledAt(): ?\DateTimeInterface
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(\DateTimeInterface $scheduledAt): static
    {
        $this->scheduledAt = $scheduledAt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }
}
