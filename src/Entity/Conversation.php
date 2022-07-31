<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConversationRepository::class)]
class Conversation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $last_message_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastMessageId(): ?int
    {
        return $this->last_message_id;
    }

    public function setLastMessageId(int $last_message_id): self
    {
        $this->last_message_id = $last_message_id;

        return $this;
    }
}
