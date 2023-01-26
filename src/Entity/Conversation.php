<?php

namespace App\Entity;

use App\Repository\ConversationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[ORM\Entity(repositoryClass: ConversationRepository::class)]
class Conversation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: Participant::class, mappedBy: "conversation_id")]
    #[ORM\JoinColumn(name:"participant_id", referencedColumnName:"id")]
    private Collection $participants;

    #[ORM\OneToOne(targetEntity: Message::class)]
    #[ORM\JoinColumn(name:"last_message_id", referencedColumnName:"id")]
    private ?int $last_message_id = null;

    #[ORM\OneToMany(targetEntity: Message::class, mappedBy: "conversation_id")]
    #[ORM\JoinColumn(name:"conversation_id", referencedColumnName:"id")]
    private Collection $messages;

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

    /**
     * @return Collection<int, Participant>
     */
    public function getParticipants(): Collection
    {
        return $this->participants;
    }

    public function addParticipant(Participant $participant): self
    {
        if (!$this->participants->contains($participant)) {
            $this->participants[] = $participant;
            $participant->setConversationId(null); //TODO při problému fixnout přidat id
        }

        return $this;
    }

    public function removeParticipant(Participant $participant): self
    {
        if ($this->participants->removeElement($participant)) {
            
            if ($participant->getConversationId() === $this) {
                $participant->setConversationId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Message>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Message $message, ?int $setConversationId): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages[] = $message;
            $message->setConversationId($setConversationId);
        }

        return $this;
    }

    public function removeMessage(Message $message): self
    {
        if ($this->messages->removeElement($message)) {
           
            if ($message->getConversationId() === $this) {
                $message->setConversationId(null);
            }
        }

        return $this;
    }
}
