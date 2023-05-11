<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/UserController.php',
        ]);
    }

    #[Route('/user/get', name: 'app_user_get', methods: ['GET'])]
    public function fetchUsers(
        UserRepository $user,
        SerializerInterface $serializer
    ): JsonResponse {
        return new JsonResponse($serializer->serialize($user->findAll(), 'json', ['groups' => 'fetchUsers']));
    }

    #[Route('/user/create', name: 'app_user_create', methods: ['POST'])]
    public function addUser(
        EntityManagerInterface $manager,
        Request $request,
        UserPasswordHasherInterface $hasher,
        ValidatorInterface $validator
    ): Response {
        $user = new User();

        $user->setNom($request->request->get('nom'));
        $user->setPrenom($request->request->get('prenom'));
        $user->setEmail($request->request->get('email'));
//        $user->setRole($manager->getRepository(Role::class)->find($request->get('role')));
        $password = $request->request->get('password');

        $passwordValidator = $validator->validate($password, [
            new Length(['min' => 8, 'minMessage' => 'Le mot de passe doit contenir minimum 8 caractères']),
            new NotBlank(['message' => 'Le mot de passe ne peut être vide']),
            new Regex([
                'pattern' => '/\d+/i',
                'message' => 'Le mot de passe doit contenir au moins un chiffre',
            ]),
            new Regex([
                'pattern' => '/[#?!@$%^&*-]+/i',
                'message' => 'Le mot de passe doit contenir au minimum un caractère spécial',
            ]),
        ]);

        $userValidator = $validator->validate($user);

        if (count($userValidator) >= 1) {
            throw new \JsonException($userValidator);
        }

//        $emailValidator = $validator->validate($user->getEmail(), [
//            new Email(['message' => ''])
//        ]);

        if ($passwordValidator != '') {
            return new Response($passwordValidator);
        }



        $user->setPassword($hasher->hashPassword($user, $password));
        $manager->persist($user);
        $manager->flush();

        return new Response('Done');
    }

    #[Route('/user/edit/${id}', name: 'app_user_edit', methods: ['PUT'])]
    public function editUser() {

    }

    #[Route('/user/delete/${id}', name: 'app_user_delete', methods: ['DELETE'])]
    public function deleteUser(User $user, EntityManagerInterface $manager) {
        $manager->remove($user);
        $manager->flush();
    }
}
