<?php

namespace App\Controller;

use App\Entity\Evaluation;
use App\Entity\User;
use App\Repository\EtatRepository;
use App\Repository\EvaluationRepository;
use App\Repository\FormationRepository;
use App\Repository\QuizRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

class EvaluationController extends AbstractController
{
    #[Route('/evaluation', name: 'app_evaluation')]
    public function index(
        EvaluationRepository $evaluationRepository,
        #[CurrentUser] $user,
        SerializerInterface $serializer
    ): Response|JsonResponse {
        if ($user) {
            $criteria = Criteria::create()->where(Criteria::expr()->in('formation', $user->getFormation()->toArray()));
            $evaluations = $evaluationRepository->matching($criteria);

            return new JsonResponse($serializer->serialize($evaluations, 'json', ['groups' => 'fetchUserEvaluations']));
        }
        return new JsonResponse('[]');
    }

    #[Route('/evaluation/{id}', name: 'app_evaluation_data')]
    public function getEvaluationData(
        Evaluation $evaluation,
        #[CurrentUser] $user,
        SerializerInterface $serializer
    ) : Response|JsonResponse {
        $copie = $this->getExistingCopie($user, $evaluation);
        $started = !$copie->isEmpty();

        $url = $copie->isEmpty() ? '/copie/create' : '/copie/' . $copie[0]->getId();

        $serializedResponse = $serializer->serialize($evaluation, 'json', ['groups' => 'fetchUserEvaluations']);
        $serializedResponse = json_decode($serializedResponse, true);
        $serializedResponse['started'] = $started;
        $serializedResponse['url'] = $url;

        return new JsonResponse(json_encode($serializedResponse));
    }

    #[Route('/evaluation/create', name: 'app_evaluation_create', methods: ['POST'])]
    public function createEvaluation(
        Request $request,
        QuizRepository $quizRepository,
        FormationRepository $formationRepository,
        EtatRepository $etatRepository,
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager
    ) : Response {
        $quiz = $quizRepository->find($request->request->get('idQuiz'));
        $quizOwner = $quiz->getFormateur();
        $formation = $formationRepository->find($request->request->get('formation'));
        $hasFormateurFormation = $formateur->getFormation()->contains($formation);

        if ($quizOwner === $formateur && $hasFormateurFormation) {
            $evaluation = new Evaluation();

            $evaluation->setQuiz($quiz);
            $evaluation->setFormation($formation);
            $evaluation->setEtat($etatRepository->find('1'));
            $evaluation->setDateDebut(new \DateTime($request->request->get('dateDebut')));
            $evaluation->setDateFin(new \DateTime($request->request->get('dateFin')));

            $manager->persist($evaluation);
            $manager->flush();

            return new Response('Evaluation créée');
        }

        return new Response("Vous avez essayé de créer une évaluation à partir de données sur lesquelles vous n'avez pas de droits");
    }

    #[Route('/evaluation/{id}/edit', name: 'app_evaluation_edit', methods: ['POST'])]
    public function editEvaluation(
        Evaluation $evaluation,
        Request $request,
        QuizRepository $quizRepository,
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager
    ) : Response {
        if (new \DateTime() < $evaluation->getDateDebut()) {
            $quizOwner = $evaluation->getQuiz()->getFormateur();
            if ($quizOwner === $formateur) {
                $evaluation->setQuiz($quizRepository->find($request->request->get('idQuiz')));
                $evaluation->setDateDebut(new \DateTime($request->request->get('dateDebut')));
                $evaluation->setDateFin(new \DateTime($request->request->get('dateFin')));

                $manager->flush();

                return new Response('Evaluation modifiée.');
            }
            return new Response('Cette évaluation ne vous appartient pas.');
        }
        return new Response('Il est trop tard pour modifier cette évaluation.');
    }

    #[Route('/evaluation/{id}/delete', name: 'app_evaluation_delete', methods: ['DELETE'])]
    public function deleteEvaluation(
        Evaluation $evaluation,
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager
    ) : Response {
        $quizOwner = $evaluation->getQuiz()->getFormateur();

        if ($quizOwner === $formateur) {
            $manager->remove($evaluation);
            $manager->flush();

            return new Response('Evaluation supprimée.');
        }

        return new Response('Cette évaluation ne vous appartient pas.');
    }

    /**
     * @param ?User $user
     * @param Evaluation $evaluation
     * @return Collection
     */
    public function getExistingCopie(?User $user, Evaluation $evaluation): Collection
    {
        $criteria = Criteria::create()->where(Criteria::expr()->eq('user', $user));
        return $evaluation->getCopies()->matching($criteria);
    }
}
