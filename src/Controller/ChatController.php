<?php

namespace App\Controller;

use App\Mercure\CookieGenerator;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ChatController extends AbstractController
{
    /**
     * @Route("/chat", name="chat")
     */
    public function __invoke(CookieGenerator $cookieGenerator): Response
    {
        $response = $this->render('chat/chat.html.twig', []);
        $response->headers->setCookie($cookieGenerator->generate());
        $user = $this->getUser();
        dump($user);
        return $response;
    }
}
