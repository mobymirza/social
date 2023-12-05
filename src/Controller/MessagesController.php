<?php

namespace App\Controller;

use App\Dto\MessageDto;
use App\Service\MessageExchangeService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MessagesController extends AbstractController
{
    #[Route('/messages/{contact_id}', name: 'messages.send',methods: 'POST')]
    public function send($contact_id,Request $request,MessageExchangeService $messageExchangeService): Response
    {
        $senderId = $request->getSession()->get('user_id');
        $message = $request->request->get('message');

        $messageDto = new MessageDto($message,$contact_id,$senderId);
        $messageExchangeService->save($messageDto);
      return  $this->redirectToRoute('messages.show-single',[
          'contact_id' => $contact_id
      ]);
    }


    #[Route('/messages', name: 'messages.list',methods: 'GET', priority: 1)]
    public function listMessages (Request $request,MessageExchangeService $messageExchangeService): Response
    {
        $receiverId = $request->getSession()->get('user_id');
        $messageExchangeService->getDirectMessageByUserId($receiverId);
        $messages = $messageExchangeService->showUser($receiverId);
        return $this->render('message_exchange/show.html.twig', [
            'messages' => $messages,
        ]);
    }


     #[Route('/messages/{contact_id}', name: 'messages.show-single',methods: 'GET')]
     public function showSingleMessage(int $contact_id,Request $request,MessageExchangeService $messageExchangeService): Response
     {
         $currentUserId = $request->getSession()->get('user_id');
         $messages = $messageExchangeService->getMessages($contact_id,$currentUserId);
        return $this->render('message_exchange/index.html.twig', [
            'messages' => $messages,
            'currentUserId' => $currentUserId,
            'contact_id'=> $contact_id
        ]);
     }
}
