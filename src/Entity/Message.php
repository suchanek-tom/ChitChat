<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: MessageRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Message
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type:'integer')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Conversation::class, inversedBy:"messages")]
    private ?int $conversation_id = null;

    #[ORM\ManyToOne(targetEntity:"User", inversedBy:"messages")]
    private ?int $user_id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(type: 'string')]
    private $mine;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(?int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

     /**
     * @return mixed
     */
    public function getMine(): mixed
    {
        return $this->mine;
    }

    /**
     * @param mixed $mine
     */
    public function setMine(mixed $mine): void
    {
        $this->mine = $mine;
    }
}
