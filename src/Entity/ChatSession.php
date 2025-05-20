<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ChatSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ChatSessionRepository::class)]
#[ORM\Table(name: 'chat_session')]
class ChatSession
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    /** Date de début de la session */
    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $startedAt;

    /**
     * @var Collection<int, ChatMessage>
     */
    #[ORM\OneToMany(mappedBy: 'session', targetEntity: ChatMessage::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $messages;

    public function __construct()
    {
        $this->startedAt = new \DateTimeImmutable();
        $this->messages  = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartedAt(): \DateTimeInterface
    {
        return $this->startedAt;
    }

    /**
     * @return Collection<int, ChatMessage>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(ChatMessage $message): static
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setSession($this);
        }

        return $this;
    }

    public function removeMessage(ChatMessage $message): static
    {
        if ($this->messages->removeElement($message)) {
            // dissocier de la session si nécessaire
            if ($message->getSession() === $this) {
                $message->setSession(null);
            }
        }

        return $this;
    }
}
