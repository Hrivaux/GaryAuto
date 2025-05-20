<?php
// src/Entity/Address.php
declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
class Address
{
    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private string $street;

    #[ORM\Column(type: 'string', length: 50)]
    #[Assert\NotBlank]
    private string $postalCode;

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    private string $city;

    #[ORM\Column(type: 'string', length: 2)]
    #[Assert\NotBlank]
    #[Assert\Country]
    private string $country;

    public function __construct(string $street = '', string $postalCode = '', string $city = '', string $country = '')
    {
        $this->street = $street;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->country = $country;
    }

    public function getStreet(): string
    {
        return $this->street;
    }
    public function setStreet(string $s): static
    {
        $this->street = $s;
        return $this;
    }

    public function getPostalCode(): string
    {
        return $this->postalCode;
    }
    public function setPostalCode(string $p): static
    {
        $this->postalCode = $p;
        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }
    public function setCity(string $c): static
    {
        $this->city = $c;
        return $this;
    }

    public function getCountry(): string
    {
        return $this->country;
    }
    public function setCountry(string $c): static
    {
        $this->country = $c;
        return $this;
    }
}
