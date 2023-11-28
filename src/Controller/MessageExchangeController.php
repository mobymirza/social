<?php

namespace App\Controller;

use App\Dto\MessageDto;
use App\Service\MessageExchangeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MessageExchangeController extends AbstractController
{
    #[Route('/save/message', name: 'store-message',methods: 'POST')]
    public function index(Request $request,MessageExchangeService $messageExchangeService): Response
    {
         $userReceiver = $request->getSession()->get('user_id');
        $userSender = $request->request->get('send_id');
        $text = $request->request->get('message');
        $messageDto = new MessageDto($text,$userSender,$userReceiver);
        $messageExchangeService->save($messageDto);
        return $this->render('message_exchange/index.html.twig', [
            'controller_name' => 'MessageExchangeController',
        ]);
    }


    #[Route('/show/message', name: 'show-message',methods: 'GET')]
    public function showAll(Request $request,MessageExchangeService $messageExchangeService): Response
    {

        $reciveId = $request->getSession()->get('user_id');
        $messages = $messageExchangeService->showUser($reciveId);
        return $this->render('message_exchange/show.html.twig', [
            'messages' => $messages,
        ]);
    }


     #[Route('/message/{contact_id}', name: 'message-user',methods: 'GET')]
     public function showUser(int $contact_id,Request $request,MessageExchangeService $messageExchangeService): Response
     {
         $currentUserId = $request->getSession()->get('user_id');
         $messages = $messageExchangeService->getMessages($contact_id,$currentUserId);
        return $this->render('message_exchange/index.html.twig', [
            'messages' => $messages,
            'currentUserId' => $currentUserId
        ]);
     }
}
