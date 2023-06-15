<?php

namespace App\Controller;

use App\Entity\Copie;
use App\Entity\Question;
use App\Entity\Reponse;
use App\Entity\User;
use App\Repository\CopieRepository;
use App\Repository\QuestionRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class CopieController extends AbstractController
{
    #[Route('/copie/{id}', name: 'app_copie_get_data')]
    public function index(
        Copie $copie,
        CopieRepository $copieRepository,
        #[CurrentUser] User $user
    ): JsonResponse|Response
    {
        if (($this->isGranted('ROLE_FORMATEUR') && !$copie->isACorriger()) || ($this->isGranted('ROLE_ELEVE') && $copie->getUser() !== $user)) {
            return new Response('Vous ne pouvez consulter cette copie.', 404);
        }

        return $this->json($copieRepository->findAllCopieQuestionsWithResponses($copie));
    }

    #[Route('/copie/{id}/correct')]
    public function correctCopie(
        Copie $copie,
        CopieRepository $copieRepository,
        #[CurrentUser] User $formateur,
        Request $request,
        EntityManagerInterface $manager,
    ) : Response {
        if ($copie->getEvaluation()->getQuiz()->getFormateur() !== $formateur) {
            return new Response('Cette copie ne vous appartient pas.', 404);
        }

        $copie->setAnnotation($request->request->get('annotation') ?? '');
        $copie->setNote($copieRepository->findNoteCopie($copie));

        $manager->flush();

        return new Response($copie->getEvaluation()->getId());
    }

    #[Route('/copie/{id}/lock')]
    public function copieLock(
        Copie $copie,
        #[CurrentUser] User $eleve,
        EntityManagerInterface $manager
    ) : Response {
        if ($copie->isEstCloture()) {
            return new Response('Cette copie a déjà été validée.');
        }

        if ($copie->getUser() !== $eleve) {
            return new Response('Cette copie ne vous appartient pas.');
        }

        $copie->setEstCloture(true);

        $manager->flush();

        return new Response($copie->getEvaluation()->getId());
    }

    #[Route('/copie/{id}/reponse/add', name: 'app_reponse_create', methods: ['POST'])]
    public function reponse(
        Copie $copie,
        QuestionRepository $questionRepository,
        Request $request,
        #[CurrentUser] User $user,
        EntityManagerInterface $manager
    ) : Response {
        if ($this->isGranted('ROLE_FORMATEUR')) {
            if ($copie->getEvaluation()->getQuiz()->getFormateur() !== $user) {
                return new Response('Vous ne pouvez pas corriger cette copie.');
            }
        } else if($this->isGranted('ROLE_ELEVE')) {
            if ($copie->getUser() !== $user) {
                return new Response('Cette copie ne vous appartient pas.');
            }

            if ($copie->isEstCloture()) {
                return new Response('Cette copie a déjà été validée.');
            }
        } else {
            return new Response('error');
        }

        $question = $questionRepository->find($request->request->get('idQuestion'));
        $criteria = Criteria::create()->where(Criteria::expr()->eq('question', $question));
        $existingReponse = $copie->getReponses()->matching($criteria);

        if ($existingReponse->isEmpty()) {
            return $this->createReponse($copie, $question, $request, $manager);
        } else {
            if ($this->isGranted('ROLE_FORMATEUR')) {
                return $this->correctReponse($existingReponse[0], $request, $manager);
            }
            return $this->editReponse($existingReponse[0], $request, $manager);
        }
    }

    public function createReponse(
        Copie $copie,
        Question $question,
        Request $request,
        EntityManagerInterface $manager
    ): Response
    {
        $reponse = new Reponse();
        $reponse->setCopie($copie);
        $reponse->setQuestion($question);

        if ($this->isGranted('ROLE_ELEVE')) {
            $reponse->setReponse($request->request->get('reponse'));
            $reponse->setRepChoix1($request->request->get('choix1') ?? 0);
            $reponse->setRepChoix2($request->request->get('choix2') ?? 0);
            $reponse->setRepChoix3($request->request->get('choix3') ?? 0);
            $reponse->setRepChoix4($request->request->get('choix4') ?? 0);
        } else if ($this->isGranted('ROLE_FORMATEUR')) {
            $reponse->setRepChoix1(0);
            $reponse->setRepChoix2(0);
            $reponse->setRepChoix3(0);
            $reponse->setRepChoix4(0);
            $reponse->setNote($request->request->get('note'));
            $reponse->setAnnotation($request->request->get('annotation'));
        }

        $manager->persist($reponse);
        $manager->flush();

        return new Response('Nouvelle réponse créée.');
    }

    public function editReponse(
        Reponse $reponse,
        Request $request,
        EntityManagerInterface $manager
    ): Response
    {
        $reponse->setReponse($request->request->get('reponse'));
        $reponse->setRepChoix1($request->request->get('choix1') ?? 0);
        $reponse->setRepChoix2($request->request->get('choix2') ?? 0);
        $reponse->setRepChoix3($request->request->get('choix3') ?? 0);
        $reponse->setRepChoix4($request->request->get('choix4') ?? 0);

        $manager->flush();

        return new Response('Réponse modifiée.');
    }

    public function correctReponse(
        Reponse $reponse,
        Request $request,
        EntityManagerInterface $manager
    ) : Response {
        $reponse->setNote($request->request->get('note') ?? $reponse->getQuestion()->getNoteMax());
        $reponse->setAnnotation($request->request->get('annotation'));

        $manager->flush();

        return new Response('Réponse corrigée.');
    }
}
