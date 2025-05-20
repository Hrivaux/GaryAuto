<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ChatMessageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatMessageRepository::class)]
#[ORM\Table(name: 'chat_message')]
class ChatMessage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: ChatSession::class, inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private ChatSession $session;

    #[ORM\Column(type: 'text')]
    private string $content;

    #[ORM\Column(type: 'string', length: 10)]
    private string $author; // 'user' ou 'bot'

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $sentAt;

    public function __construct()
    {
        $this->sentAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSession(): ChatSession
    {
        return $this->session;
    }

    public function setSession(ChatSession $session): static
    {
        $this->session = $session;
        return $this;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): static
    {
        $this->author = $author;
        return $this;
    }

    public function getSentAt(): \DateTimeInterface
    {
        return $this->sentAt;
    }

    public function setSentAt(\DateTimeInterface $sentAt): static
    {
        $this->sentAt = $sentAt;
        return $this;
    }
}
