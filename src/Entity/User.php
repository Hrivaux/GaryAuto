<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

#[Vich\Uploadable]
#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 180, unique: true)]
    private ?string $email = null;

    /** @var list<string> */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Vehicle::class, orphanRemoval: true)]
    private Collection $vehicles;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $avatarName = null;

    #[Vich\UploadableField(mapping: 'user_avatar', fileNameProperty: 'avatarName')]
    private ?File $avatarFile = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: 'boolean')]
    private bool $profileComplete = false;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(type: 'string', length: 100, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $phone = null;

    // Embed Address value object instead of a raw string
    #[ORM\Embedded(class: Address::class)]
    private Address $address;

    public function __construct()
    {
        $this->vehicles = new ArrayCollection();
        $this->address = new Address();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // …
    }

    /**
     * @return Collection<int, Vehicle>
     */
    public function getVehicles(): Collection
    {
        return $this->vehicles;
    }

    public function addVehicle(Vehicle $vehicle): static
    {
        if (!$this->vehicles->contains($vehicle)) {
            $this->vehicles->add($vehicle);
            $vehicle->setUser($this);
        }
        return $this;
    }

    public function removeVehicle(Vehicle $vehicle): static
    {
        if ($this->vehicles->removeElement($vehicle)) {
            if ($vehicle->getUser() === $this) {
                $vehicle->setUser(null);
            }
        }
        return $this;
    }

    public function getAvatarName(): ?string
    {
        return $this->avatarName;
    }

    public function setAvatarName(?string $avatarName): static
    {
        $this->avatarName = $avatarName;
        return $this;
    }

    public function getAvatarFile(): ?File
    {
        return $this->avatarFile;
    }

    public function setAvatarFile(?File $avatarFile = null): static
    {
        $this->avatarFile = $avatarFile;
        if (null !== $avatarFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function isProfileComplete(): bool
    {
        return $this->profileComplete;
    }

    public function setProfileComplete(bool $profileComplete): static
    {
        $this->profileComplete = $profileComplete;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): static
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): static
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;
        return $this;
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): static
    {
        $this->address = $address;
        return $this;
    }

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password,
            'roles' => $this->roles,
            'avatarName' => $this->avatarName,
            'updatedAt' => $this->updatedAt?->format(\DateTimeInterface::ATOM),
            'profileComplete' => $this->profileComplete,
            'firstName' => $this->firstName,
            'lastName' => $this->lastName,
            'phone' => $this->phone,
            // store address as array
            'address' => [
                'street' => $this->address->getStreet(),
                'postalCode' => $this->address->getPostalCode(),
                'city' => $this->address->getCity(),
                'country' => $this->address->getCountry(),
            ],
        ];
    }

    public function __unserialize(array $data): void
    {
        $this->id = $data['id'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->roles = $data['roles'];
        $this->avatarName = $data['avatarName'];
        $this->updatedAt = isset($data['updatedAt']) ? new \DateTimeImmutable($data['updatedAt']) : null;
        $this->profileComplete = $data['profileComplete'];
        $this->firstName = $data['firstName'];
        $this->lastName = $data['lastName'];
        $this->phone = $data['phone'];
        $addr = $data['address'] ?? [];
        $this->address = new Address(
            $addr['street'] ?? '',
            $addr['postalCode'] ?? '',
            $addr['city'] ?? '',
            $addr['country'] ?? ''
        );
    }

    #[ORM\OneToOne(mappedBy: 'user', targetEntity: ParametreUser::class, cascade: ['persist', 'remove'])]
private ?ParametreUser $parametreUser = null;

public function getParametreUser(): ?ParametreUser
{
    return $this->parametreUser;
}

public function setParametreUser(?ParametreUser $parametreUser): self
{
    $this->parametreUser = $parametreUser;
    return $this;
}

}
