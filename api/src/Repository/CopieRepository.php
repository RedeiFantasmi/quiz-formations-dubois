<?php

namespace App\Repository;

use App\Entity\Copie;
use App\Entity\Evaluation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Copie>
 *
 * @method Copie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Copie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Copie[]    findAll()
 * @method Copie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CopieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Copie::class);
    }

    public function save(Copie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Copie $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllCopieQuestionsWithResponses($copie): array
    {
        return $this->createQueryBuilder('c')
            ->select('qu.id', 'qu.enonce', 'qu.qcm', 'qu.noteMax', 'qu.choix1', 'qu.choix2', 'qu.choix3', 'qu.choix4', 'r.reponse', 'r.repChoix1', 'r.repChoix2', 'r.repChoix3', 'r.repChoix4', 'r.note', 'r.annotation', 'c.estCloture', 'e.estCloture AS corrige', 'e.dateFin')
            ->innerJoin('c.evaluation', 'e')
            ->innerJoin('e.quiz', 'q')
            ->innerJoin('q.questions', 'qu')
            ->LeftJoin('c.reponses', 'r', Expr\Join::WITH, 'r.question = qu.id')
            ->where('c = :copie')
            ->setParameter('copie', $copie)
            ->getQuery()
            ->getResult();
    }

    public function findNoteCopie($copie): int
    {
        return $this->createQueryBuilder('c')
            ->select('SUM(r.note) AS noteCopie')
            ->innerJoin('c.reponses', 'r')
            ->where('c = :copie')
            ->setParameter('copie', $copie)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findMoyenneGeneraleEleve(
        User $eleve,
        EvaluationRepository $evaluationRepository
    ): int
    {
        $q = $this->createQueryBuilder('c')
            ->select('e.id', 'c.note')
            ->innerJoin('c.evaluation', 'e')
            ->where('c.user = :el')
            ->setParameter('el', $eleve)
            ->getQuery()
            ->getResult();

        $notes = [];
        foreach ($q as $copie) {
            $noteMax = $evaluationRepository->findNoteMaxEvaluation($copie['id']);
            if ($noteMax !== 20) {
                $notes[] = $copie['note'] * 20 / $noteMax;
            } else {
                $notes[] = $copie['note'];
            }
        }

        return (array_sum($notes)) / count($notes);
    }

    public function findEleveLastCorrectCopie(User $eleve): array
    {
        return $this->createQueryBuilder('c')
            ->select('e.id', 'c.note', 'q.titre')
            ->innerJoin('c.evaluation', 'e')
            ->innerJoin('e.quiz', 'q')
            ->where('c.user = :el AND e.estCloture = 1')
            ->orderBy('e.dateFin', 'DESC')
            ->setMaxResults('1')
            ->setParameter('el', $eleve)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Copie[] Returns an array of Copie objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Copie
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
