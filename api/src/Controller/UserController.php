<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;


class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/user/get', name: 'app_user_get')]
    public function fetchUsers(UserRepository $user, SerializerInterface $serializer): JsonResponse {
        return new JsonResponse($serializer->serialize($user->findAll(), 'json', ['groups' => 'fetchUsers']));
    }

//    #[Route('/user/add/${name}', name: 'app_user_add')]
//    public function addUser(UserRepository $user) {
//        $user->
//    }
}
