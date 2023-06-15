<?php

namespace App\Controller;

use App\Entity\Formation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class FormationController extends AbstractController
{
    #[Route('/formation', name: 'app_formation')]
    public function index(
        #[CurrentUser] $user,
        SerializerInterface $serializer
    ): JsonResponse|Response
    {
        if ($user) {
            return new JsonResponse($serializer->serialize($user->getFormation(), 'json', ['groups' => 'fetchUserFormations']));
        }

        return new Response('Pas connecté');
    }

    #[Route('/formation/{id}/eleves')]
    public function getFormationEleves(
        Formation $formation,
        #[CurrentUser] $user,
        SerializerInterface $serializer
    ) : JsonResponse|Response {
        if ($user && $user->getFormation()->contains($formation)) {
            return new JsonResponse($serializer->serialize($formation->getUsers(), 'json'));
        }

        return new Response('not found', 404);
    }
}
