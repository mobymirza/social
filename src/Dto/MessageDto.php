<?php

namespace App\Dto;

class MessageDto
{

    private string $message;
    private int $user_sender;
    private  int $user_receiver;


    public function __construct(string $message,int $user_sender,int $user_receiver)
    {
        $this->message = $message;
        $this->user_sender = $user_sender;
        $this->user_receiver = $user_receiver;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getUserSender(): int
    {
        return $this->user_sender;
    }

    /**
     * @return int
     */
    public function getUserReceiver(): int
    {
        return $this->user_receiver;
    }
}