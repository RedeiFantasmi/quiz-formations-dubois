<?php

namespace App\Controller;

use App\Entity\Copie;
use App\Entity\Evaluation;
use App\Entity\Quiz;
use App\Entity\User;
use App\Repository\QuizRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class HomeController extends AbstractController
{
    #[Route('/accueil', name: 'app_home')]
    public function index(
        #[CurrentUser] User $user,
        EntityManagerInterface $manager
    ): Response|JsonResponse
    {
        if ($this->isGranted('ROLE_FORMATEUR')) {
            return $this->accueilFormateur($user, $manager);
        } else if ($this->isGranted('ROLE_ELEVE')) {
            return $this->accueilEleve($user, $manager);
        }

        return new Response('');
    }

    public function accueilFormateur(
        User $formateur,
        EntityManagerInterface $manager
    ) : JsonResponse
    {
        $data = [];
        $data['lastQuiz'] = $manager->getRepository(Quiz::class)->findLastThreeFormateurQuiz($formateur);
        $data['comingEvaluations'] = $manager->getRepository(Evaluation::class)->findComingEvaluationsFormateur($formateur);
        $data['evaluationsToCorrect'] = $manager->getRepository(Evaluation::class)->findEvaluationsToCorrect($formateur);

        return $this->json($data);
    }

    public function accueilEleve(
        User $eleve,
        EntityManagerInterface $manager
    ) : JsonResponse
    {
        $data = [];
        $copieRepository = $manager->getRepository(Copie::class);
        $evaluationRepository = $manager->getRepository(Evaluation::class);

        $data['moyenneGenerale'] = $copieRepository->findMoyenneGeneraleEleve($eleve, $evaluationRepository);
        $data['lastCorrectCopie'] = $copieRepository->findEleveLastCorrectCopie($eleve);
        $data['lastCorrectCopie']['noteMax'] = $evaluationRepository->findNoteMaxEvaluation($data['lastCorrectCopie']['id']);
        $data['currentEvaluations'] = $evaluationRepository->findCurrentEvaluationsEleve($eleve);
        $data['comingEvaluations'] = $evaluationRepository->findComingEvaluationsEleve($eleve);

        return $this->json($data);
    }
}
