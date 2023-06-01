<?php

namespace App\Controller;

use App\Entity\Quiz;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class QuizController extends AbstractController
{
    #[Route('/quiz', name: 'app_quiz')]
    public function index(
        #[CurrentUser] $formateur,
        SerializerInterface $serializer
    ): Response|JsonResponse {
        if ($formateur) {
            return new JsonResponse($serializer->serialize($formateur->getQuiz(), 'json', ['groups' => 'fetchFormateurQuiz']));
        }

        return new Response("Vous n'avez pas encore créé de quiz.");
    }

    #[Route('/quiz/create', name: 'app_quiz_create', methods: ['POST'])]
    public function createQuiz(
        Request $request,
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager,
    ): Response {
        $quiz = new Quiz();

        $quiz->setFormateur($formateur);
        $quiz->setTitre($request->request->get('quiz-name'));
        $quiz->setDateCreation(new \DateTime());

        $manager->persist($quiz);
        $manager->flush();

        return new Response($quiz->getId());
    }

    #[Route('/quiz/{id}', name: 'app_quiz_info')]
    public function getQuizData(
        Quiz $quiz,
        #[CurrentUser] $user,
        SerializerInterface $serializer
    ) : Response|JsonResponse {
        return new JsonResponse($serializer->serialize(['data' => $quiz, 'questions' => $quiz->getQuestions()], 'json', ['groups' => 'fetchQuizData']));
    }

    #[Route('/quiz/{id}/reponses', name: 'app_quiz_reponses')]
    public function getQuizReponses(
        Quiz $quiz,
        #[CurrentUser] $user,
        SerializerInterface $serializer
    ) : JsonResponse {
        return new JsonResponse($serializer->serialize($quiz->getQuestions(), 'json', ['groups' => 'fetchQuizQuestions']));
    }

    #[Route('/quiz/{id}/edit', name: 'app_quiz_edit', methods: ['POST'])]
    public function editQuiz(
        Quiz $quiz,
        Request $request,
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager
    ) : Response {
        $quizOwner = $quiz->getFormateur();

        if ($quizOwner === $formateur) {
            $quiz->setTitre($request->request->get('quiz-name'));
            $manager->flush();

            return new Response('Titre du quiz changé en "' . $quiz->getTitre() . '"');
        }
        return new Response('Le quiz "' . $quiz->getTitre() . '" ne vous appartient pas.');
    }

    #[Route('/quiz/{id}/delete', name: 'app_quiz_delete', methods: ['DELETE'])]
    public function deleteQuiz(
        Quiz $quiz,
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager
    ) : Response {
        $quizOwner = $quiz->getFormateur();

        if ($quizOwner === $formateur) {
            $manager->remove($quiz);
            $manager->flush();

            return new Response('Votre quiz "' . $quiz->getTitre() . '" a été supprimé.');
        }

        return new Response('Le quiz "' . $quiz->getTitre() . '" ne vous appartient pas.');
    }
}
