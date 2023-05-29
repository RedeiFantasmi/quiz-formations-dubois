<?php

namespace App\Controller;

use App\Entity\Copie;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\User;
use App\Repository\CopieRepository;
use App\Repository\EvaluationRepository;
use App\Repository\QuestionRepository;
use App\Repository\ReponseRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class CopieController extends AbstractController
{
    #[Route('/copie', name: 'app_copie')]
    public function index(): Response
    {
        return $this->render('copie/index.html.twig', [
            'controller_name' => 'CopieController',
        ]);
    }

    #[Route('/copie/create', name: 'app_copie_create', methods: ['POST'])]
    public function createCopie(
        Request $request,
        EvaluationRepository $evaluationRepository,
        CopieRepository $copieRepository,
        #[CurrentUser] $eleve,
        EntityManagerInterface $manager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ELEVE');

        $evaluation = $evaluationRepository->find($request->request->get('idEvaluation'));
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

        $manager->persist($copie);
        $manager->flush();

        return new Response('Copie créée.');
    }

    #[Route('/copie/{id}/reponse/add', name: 'app_reponse_create', methods: ['POST'])]
    public function reponse(
        Copie $copie,
        QuestionRepository $questionRepository,
        Request $request,
        #[CurrentUser] $eleve,
        EntityManagerInterface $manager
    ) {
        $question = $questionRepository->find($request->request->get('idQuestion'));

        $criteria = Criteria::create()->where(Criteria::expr()->eq('question', $question));
        $existingReponse = $copie->getReponses()->matching($criteria);
        if ($existingReponse->isEmpty()) {
            $this->createReponse($copie, $question, $request, $eleve, $manager);
        } else {
            $this->editReponse($existingReponse, $request, $eleve, $manager);
        }
    }

    public function createReponse(
        Copie $copie,
        Question $question,
        Request $request,
        User $eleve,
        EntityManagerInterface $manager
    ): Response
    {



        if ($copie->getUser() === $eleve) {
            $reponse = new Reponse();
            $reponse->setCopie($copie);
            $reponse->setQuestion($question);
            $reponse->setReponse($request->request->get('reponse'));
            $reponse->setRepChoix1($request->request->get('choix1') ?? false);
            $reponse->setRepChoix2($request->request->get('choix2') ?? false);
            $reponse->setRepChoix3($request->request->get('choix3') ?? false);
            $reponse->setRepChoix4($request->request->get('choix4') ?? false);

            $manager->persist($reponse);
            $manager->flush();

            return new Response('Nouvelle réponse créée.');
        }

        return new Response('Cette copie ne vous appartient pas.');
    }

    public function editReponse(
        Reponse $reponse,
        Request $request,
        User $user,
        EntityManagerInterface $manager
    ): Response
    {
        $reponse->setReponse($request->request->get('reponse'));
        $reponse->setReponse($request->request->get('reponse'));
        $reponse->setReponse($request->request->get('reponse'));
        $reponse->setReponse($request->request->get('reponse'));
        $reponse->setReponse($request->request->get('reponse'));

        return new Response();
    }


}
