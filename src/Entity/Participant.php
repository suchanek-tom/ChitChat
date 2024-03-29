<?php

namespace App\Entity;

use App\Repository\ParticipantRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;

#[ORM\Entity(repositoryClass: ParticipantRepository::class)]
class Participant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'participant')]
    #[ORM\JoinColumn(name: 'participant_id', referencedColumnName: 'id')]
    private ?User $user_id = null;

    #[ORM\ManyToOne(targetEntity: Conversation::class, inversedBy:"participants")]
    #[ORM\JoinColumn(name: 'conversation_id', referencedColumnName: 'id')]
    private ?int $conversation_id = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTime $messages_read_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getConversationId(): ?int
    {
        return $this->conversation_id;
    }

    public function setConversationId(?int $conversation_id): self
    {
        $this->conversation_id = $conversation_id;

        return $this;
    }

    public function getMessagesReadAt(): ?\DateTimeImmutable
    {
        return $this->messages_read_at;
    }

    public function setMessagesReadAt(\DateTimeImmutable $messages_read_at): self
    {
        $this->messages_read_at = $messages_read_at;

        return $this;
    }
}
