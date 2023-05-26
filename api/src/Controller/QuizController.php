<?php

namespace App\Controller;

use App\Entity\Quiz;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class QuizController extends AbstractController
{
    #[Route('/quiz', name: 'app_quiz')]
    public function index(): Response
    {
        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController',
        ]);
    }

    #[Route('/quiz/create', name: 'app_quiz_create', methods: ['POST'])]
    public function createQuiz(
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager,
        Request $request
    ): Response {
        $quiz = new Quiz();

        $quiz->setFormateur($formateur);
        $quiz->setTitre($request->request->get('titre'));

        $manager->persist($quiz);
        $manager->flush();

        return new Response('Votre quiz "' . $quiz->getTitre() . '" a été créé.');
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
            $quiz->setTitre($request->request->get('titre'));
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
