<?php

namespace App\Entity;

use App\Repository\ParametreUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ParametreUserRepository::class)]
class ParametreUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'parametreUser', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(length: 10)]
    private ?string $siteColor = '#3498db';

    #[ORM\Column(length: 20)]
    private ?string $font = 'sans-serif';

    #[ORM\Column(length: 10)]
    private ?string $layoutWidth = 'full';

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logoUrl = null;

    #[ORM\Column]
    private bool $darkMode = false;

    #[ORM\Column]
    private bool $showFooter = true;

    #[ORM\Column(length: 20)]
    private ?string $buttonStyle = 'rounded';

    // --- Getters / Setters ---

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getSiteColor(): ?string
    {
        return $this->siteColor;
    }

    public function setSiteColor(?string $siteColor): self
    {
        $this->siteColor = $siteColor;
        return $this;
    }

    public function getFont(): ?string
    {
        return $this->font;
    }

    public function setFont(string $font): self
    {
        $this->font = $font;
        return $this;
    }

    public function getLayoutWidth(): ?string
    {
        return $this->layoutWidth;
    }

    public function setLayoutWidth(string $layoutWidth): self
    {
        $this->layoutWidth = $layoutWidth;
        return $this;
    }

    public function getLogoUrl(): ?string
    {
        return $this->logoUrl;
    }

    public function setLogoUrl(?string $logoUrl): self
    {
        $this->logoUrl = $logoUrl;
        return $this;
    }

    public function isDarkMode(): bool
    {
        return $this->darkMode;
    }

    public function setDarkMode(bool $darkMode): self
    {
        $this->darkMode = $darkMode;
        return $this;
    }

    public function isShowFooter(): bool
    {
        return $this->showFooter;
    }

    public function setShowFooter(bool $showFooter): self
    {
        $this->showFooter = $showFooter;
        return $this;
    }

    public function getButtonStyle(): ?string
    {
        return $this->buttonStyle;
    }

    public function setButtonStyle(string $buttonStyle): self
    {
        $this->buttonStyle = $buttonStyle;
        return $this;
    }
}
