<?php

namespace App\Controller;

use App\Entity\Question;
use App\Repository\QuizRepository;
use App\Repository\TypeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class QuestionController extends AbstractController
{
    #[Route('/question', name: 'app_question')]
    public function index(): Response
    {
        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
        ]);
    }

    #[Route('/question/create', name: 'app_question_create', methods: ['POST'])]
    public function createQuestion(
        QuizRepository $quiz,
        TypeRepository $types,
        Request $request,
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager
    ) : Response {
        $currentQuiz = $quiz->find($request->request->get('idQuiz'));

        if ($currentQuiz->getFormateur() === $formateur) {
            $question = new Question();
            $question->setQuiz($currentQuiz);
            $this->fillQuestion($question, $types, $request);

            $manager->persist($question);
            $manager->flush();

            return new Response('Nouvelle question de type ' . $question->getType()->getLibelle() . ' créée pour le quiz "' . $currentQuiz->getTitre() . '"');
        }

        return new Response('Vous avez essayé de créer une question pour le quiz "' . $quiz->getTitre() . '" qui ne vous appartient pas.');
    }

    #[Route('/question/{id}/edit', name: 'app_question_edit', methods: ['POST'])]
    public function editQuestion(
        Question $question,
        Request $request,
        TypeRepository $types,
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager
    ) : Response {
        $quizOwner = $question->getQuiz()->getFormateur();

        if ($quizOwner === $formateur) {
            $this->fillQuestion($question, $types, $request);
            $manager->flush();

            return new Response('Une question du quiz "' . $question->getQuiz()->getTitre() . '" a été modifiée.');
        }

        return new Response('Vous avez essayé de modifier une question du quiz "' . $quiz->getTitre() . '" qui ne vous appartient pas.');
    }

    #[Route('/question/{id}/delete', name: 'app_question_delete', methods: ['DELETE'])]
    public function deleteQuestion(
        Question $question,
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager
    ) : Response {
        $quizOwner = $question->getQuiz()->getFormateur();

        if ($quizOwner === $formateur) {
            $manager->remove($question);
            $manager->flush();

            return new Response('Une question du quiz "' . $question->getQuiz()->getTitre() . '" a été supprimée.');
        }

        return new Response('Vous avez essayé de supprimer une question du quiz "' . $question->getQuiz()->getTitre() . '" qui ne vous appartient pas.');
    }

    /**
     * @param Question $question
     * @param TypeRepository $types
     * @param Request $request
     * @return void
     */
    public function fillQuestion(Question $question, TypeRepository $types, Request $request): void
    {
        $question->setType($types->find($request->request->get('type')));
        $question->setEnonce($request->request->get('enonce'));
        $question->setNoteMax($request->request->get('note'));
        $question->setChoix1($request->request->get('choix1'));
        $question->setChoix2($request->request->get('choix2'));
        $question->setChoix3($request->request->get('choix3'));
        $question->setChoix4($request->request->get('choix4'));
    }
}
