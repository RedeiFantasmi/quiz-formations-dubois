<?php

namespace App\Controller;

use App\Entity\Copie;
use App\Repository\EvaluationRepository;
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
        #[CurrentUser] $eleve,
        EntityManagerInterface $manager
    ): Response {
        $this->denyAccessUnlessGranted('ROLE_ELEVE');

        $evaluation = $evaluationRepository->find($request->request->get('idEvaluation'));
        $now = new \DateTime();
        if ($evaluation->getDateDebut() > $now) {
            return new Response("Cette évaluation n'a pas encore commencé.");
        } elseif ($evaluation->getDateFin() < $now) {
            return new Response("Cette évaluation est terminée.");
        }

//        if ($eleve->getFormation->contains($evaluation->getFormation())) {
//
//        }

//        return new Response("Vous n'êtes pas concernés par cette évaluation.");

        $copie = new Copie();
        $copie->setUser($eleve);
        $copie->setEvaluation($evaluation);

        $manager->persist($copie);
        $manager->flush();

        return new Response('Copie créée.');
    }
}
