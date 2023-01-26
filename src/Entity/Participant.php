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

    #[ORM\Column]
    #[OneToOne(targetEntity: User::class, mappedBy: 'user_id')]
    #[JoinColumn(name: 'participant_id', referencedColumnName: 'id')]
    private ?int $user_id = null;

    #[ORM\Column]
    #[ORM\ManyToOne(targetEntity: Conversation::class, inversedBy:"participants_id")]
    private ?int $conversation_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $messages_read_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
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
