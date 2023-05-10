<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['POST'])]
    public function index(#[CurrentUser] ?User $user): Response
    {
        if ($user === null) {
            return new Response('bad credentials', 401);
        }

        return new Response('authentified', 200);
//        return $this->render('login/index.html.twig', [
//            'controller_name' => 'LoginController',
//        ]);
        return new Response('test', 200);
    }
}
