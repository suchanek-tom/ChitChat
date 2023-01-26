<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;

trait Timestamp
{

    #[ORM\Column(type:'datetime')]
    private mixed $createdAt;

    /**
     * @return mixed
     */
     function getCreatedAt()
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function prePersist(): void
    {
        $this->createdAt = new DateTime();
    }
}