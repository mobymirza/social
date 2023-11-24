<?php

namespace App\Service;


use CURLFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use TelegramBot\Api\BotApi;

class TelegramBot
{
   private  HttpClientInterface $client;
   private ParameterBagInterface $parameterBag;
   const CHAT_ID = "569295350";
   public function __construct(HttpClientInterface $client,ParameterBagInterface $parameterBag)
   {
       $this->client = $client;
       $this->parameterBag = $parameterBag;
   }

    /**
     * @throws \Exception
     */
    public  function  sendMessage(string $image,string $caption): void
    {
        $token = $this->parameterBag->get('token');
       $telegram = new BotApi($token);
       $telegram->sendPhoto(
           self::CHAT_ID,
           new  CURLFile($image),
           $caption
       );
    }
}
