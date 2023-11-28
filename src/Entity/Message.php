<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageRepository::class)]
class Message
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $message = null;

    #[ORM\ManyToOne(inversedBy: 'sender')]
    private ?User $user_sender = null;

    #[ORM\ManyToOne(inversedBy: 'recive')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_recive = null;


    public function __construct(string $message,User $user_sender,User $user_recive)
    {
        $this->message = $message;
        $this->user_sender = $user_sender;
        $this->user_recive = $user_recive;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): static
    {
        $this->message = $message;

        return $this;
    }

    public function getUserSender(): ?User
    {
        return $this->user_sender;
    }

    public function setUserSender(?User $user_sender): static
    {
        $this->user_sender = $user_sender;

        return $this;
    }

    public function getUserRecive(): ?User
    {
        return $this->user_recive;
    }

    public function setUserRecive(?User $user_recive): static
    {
        $this->user_recive = $user_recive;

        return $this;
    }
}
