<?php

namespace App\Service;

use App\Dto\MessageDto;
use App\Entity\Message;
use App\Entity\User;
use App\Repository\MessageRepository;
use App\Repository\UserRepository;

class MessageExchangeService
{

    private UserRepository $userRepository;
    private MessageRepository $messageRepository;
    public function __construct(UserRepository $userRepository,MessageRepository $messageRepository)
    {
        $this->userRepository = $userRepository;
        $this->messageRepository=$messageRepository;
    }


    public function save(MessageDto $messageDto):void
    {
        $userSender = $this->userRepository->find($messageDto->getUserSender());
        $userReceiver = $this->userRepository->find($messageDto->getUserReceiver());
        $messageModel = new Message($messageDto->getMessage(),$userSender,$userReceiver);
        $this->messageRepository->save($messageModel);
    }

    public function showAll(User $user_sender):array
    {

        return $this->messageRepository->selectMessage($user_sender);
    }

    public function  findUser(int $send_id): ?User
    {
     return $this->userRepository->find($send_id);
    }

    public function getDirectMessageByUserId(int $userId)
    {
        return $this->messageRepository->getDirectListOf($userId);
    }

    public function showUser(int $user_sender)
    {
       return $this->messageRepository->showUser($user_sender);
    }



    public  function getMessages(int $user1Id, int $user2Id) :array
    {
      return $this->messageRepository->getMessagesBetweenTwoUsers($user1Id,$user2Id);
    }
}