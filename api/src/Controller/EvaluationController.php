<?php

namespace App\Controller;

use App\Entity\Copie;
use App\Entity\Evaluation;
use App\Entity\User;
use App\Repository\CopieRepository;
use App\Repository\EvaluationRepository;
use App\Repository\FormationRepository;
use App\Repository\QuizRepository;
use App\Repository\UserRepository;
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
        #[CurrentUser] User $user,
        SerializerInterface $serializer
    ): Response|JsonResponse {
        if ($this->isGranted('ROLE_FORMATEUR')) {
            $evaluations = $evaluationRepository->findAllEvaluationsFormateur($user);

            foreach ($evaluations as &$evaluation) {
                if ($evaluation['dateFin'] < new \DateTime() && !$evaluation['corrige']) {
                    $evaluation['copies'] = $evaluationRepository->findAllEleveCopiesForEvaluation($evaluation['id']);
                }
            }

            return $this->json($evaluations);
        }

        $evaluations = $evaluationRepository->findAllEvaluationsEleve($user);
        foreach ($evaluations as &$evaluation) {
            if ($evaluation['corrige']) {
                $evaluation['noteMax'] = $evaluationRepository->findNoteMaxEvaluation($evaluation['id']);
                $evaluation['moyenneClasse'] = $evaluationRepository->findMoyenneClasse($evaluation['id']);
                $evaluation['pos'] = $evaluationRepository->findElevePos($evaluation['id'], $user->getId());
                $evaluation['nbEleves'] = $evaluationRepository->findNbElevesEvaluation($evaluation['id']);
            }
        }

        return $this->json($evaluations);
    }

    #[Route('/evaluation/create', name: 'app_evaluation_create', methods: ['POST'])]
    public function createEvaluation(
        Request $request,
        QuizRepository $quizRepository,
        FormationRepository $formationRepository,
        #[CurrentUser] $formateur,
        EntityManagerInterface $manager
    ) : Response {
        $quiz = $quizRepository->find($request->request->get('quiz'));
        $quizOwner = $quiz->getFormateur();
        $formation = $formationRepository->find($request->request->get('formation'));
        $hasFormateurFormation = $formateur->getFormation()->contains($formation);

        if ($quizOwner === $formateur && $hasFormateurFormation) {
            $evaluation = new Evaluation();

            $evaluation->setQuiz($quiz);
            $evaluation->setFormation($formation);

            $dateDebut = new \DateTime($request->get('dateDebut'));
            $dateFin = new \DateTime($request->get('dateFin'));

            if ($dateFin <= $dateDebut) {
                return new Response('La date de fin est inférieure à la date de début', 400);
            }

            if ($dateDebut <= new \DateTime()) {
                return new Response('La date de début est inférieure à maintenant', 400);
            }

            $evaluation->setDateDebut($dateDebut);
            $evaluation->setDateFin($dateFin);

            $evaluation->setEstCloture(false);

            $manager->persist($evaluation);
            $manager->flush();

            return new Response('Evaluation créée');
        }

        return new Response("Vous avez essayé de créer une évaluation à partir de données sur lesquelles vous n'avez pas de droits", 401);
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
                $dateDebut = new \DateTime($request->get('dateDebut'));
                $dateFin = new \DateTime($request->get('dateFin'));

                if ($dateFin <= $dateDebut) {
                    return new Response('La date de fin est inférieure à la date de début', 400);
                }

                if ($dateDebut <= new \DateTime()) {
                    return new Response('La date de début est inférieure à maintenant', 400);
                }

                $evaluation->setDateDebut($dateDebut);
                $evaluation->setDateFin($dateFin);

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

    #[Route('/evaluation/{id}/lock', name: 'app_evaluation_lock', methods: ['POST'])]
    public function lockEvaluation(
        Evaluation $evaluation,
        EvaluationRepository $evaluationRepository,
        UserRepository $userRepository,
        #[CurrentUser] User $formateur,
        EntityManagerInterface $manager
    ) : Response {
        if ($evaluation->getQuiz()->getFormateur() === $formateur) {
            $elevesWithoutCopie = $evaluationRepository->findAllElevesWithoutCopie($evaluation);
            foreach ($elevesWithoutCopie as $eleve) {
                $copie = new Copie();
                $copie->setUser($userRepository->find($eleve));
                $copie->setEvaluation($evaluation);
                $copie->setNote(0);
                $copie->setAnnotation('Non Rendu.');
                $copie->setEstCloture(false);

                $manager->persist($copie);
            }

            $evaluation->setEstCloture(true);

            $manager->flush();

            return new Response('Evaluation corrigée.');
        }

        return new Response('Cette évaluation ne vous appartient pas.');
    }

    #[Route('/evaluation/{id}/copie/create', name: 'app_evaluation_create_copie', methods: ['POST'])]
    public function createCopie(
        Evaluation $evaluation,
        CopieRepository $copieRepository,
        #[CurrentUser] $eleve,
        EntityManagerInterface $manager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ELEVE');

        $now = new \DateTime('now');
        if ($evaluation->getDateDebut() > $now) {
            return new Response("Cette évaluation n'a pas encore commencé.");
        } elseif ($evaluation->getDateFin() < $now) {
            return new Response("Cette évaluation est terminée.");
        }

        if (!$eleve->getFormation()->contains($evaluation->getFormation())) {
            return new Response("Vous n'êtes pas concernés par cette évaluation.");
        }

        if ($copieRepository->findBy(['user' => $eleve, 'evaluation' => $evaluation])) {
            return new Response("Copie déjà existante");
        }

        $copie = new Copie();
        $copie->setUser($eleve);
        $copie->setEvaluation($evaluation);
        $copie->setEstCloture(false);

        $manager->persist($copie);
        $manager->flush();

        return new Response($copie->getId());
    }
}
