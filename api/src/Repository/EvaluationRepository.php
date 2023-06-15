<?php

namespace App\Repository;

use App\Entity\Evaluation;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\Query\Expr;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Evaluation>
 *
 * @method Evaluation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Evaluation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Evaluation[]    findAll()
 * @method Evaluation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EvaluationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Evaluation::class);
    }

    public function save(Evaluation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Evaluation $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findAllEvaluationsEleve(User $eleve): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.id', 'e.dateDebut', 'e.dateFin', 'q.titre', "CONCAT(SUBSTRING(f.prenom, 1, 1), '. ', f.nom) AS formateur", 'c.id AS copie', 'c.estCloture', 'e.estCloture AS corrige', 'c.note', 'c.annotation')
            ->leftJoin('e.copies', 'c', Expr\Join::WITH, 'c.user = :el')
            ->innerJoin('e.quiz', 'q')
            ->innerJoin('q.formateur', 'f')
            ->where('e.formation IN (:form)')
            ->setParameter('form', $eleve->getFormation())
            ->setParameter('el', $eleve)
            ->getQuery()
            ->getResult();
    }

    public function findAllElevesWithoutCopie($evaluation): array
    {
        return $this->createQueryBuilder('e')
            ->select('u.id')
            ->innerJoin('e.formation', 'f')
            ->innerJoin('f.users', 'u')
            ->leftJoin('u.copies', 'c', Expr\Join::WITH, 'c.evaluation = :eval')
            ->where('c IS NULL AND u.roles LIKE :role AND e = :eval')
            ->setParameter('eval', $evaluation)
            ->setParameter('role', '%"ROLE_ELEVE"%')
            ->getQuery()
            ->getResult();
    }

    public function findAllEvaluationsFormateur(User $formateur): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.id', 'e.dateDebut', 'e.dateFin', 'e.estCloture AS corrige', 'q.titre', "CONCAT(SUBSTRING(f.prenom, 1, 1), '. ', f.nom) AS formateur")
            ->innerJoin('e.quiz', 'q')
            ->innerJoin('q.formateur', 'f')
            ->where('e.formation IN (:form)')
            ->setParameter('form', $formateur->getFormation())
            ->getQuery()
            ->getResult();
    }

    public function findAllEleveCopiesForEvaluation($evaluation): array
    {
        return $this->createQueryBuilder('e')
            ->select('u.prenom', 'u.nom', 'u.id AS eleve', 'c.id', 'c.annotation')
            ->innerJoin('e.formation', 'f')
            ->innerJoin('f.users', 'u')
            ->leftJoin('u.copies', 'c', Expr\Join::WITH, 'c.evaluation = :eval')
            ->where('u.roles LIKE :role AND e = :eval')
            ->setParameter('role', '%"ROLE_ELEVE"%')
            ->setParameter('eval', $evaluation)
            ->getQuery()
            ->getResult();

    }

    public function findNoteMaxEvaluation($evaluation): int
    {
        return $this->createQueryBuilder('e')
            ->select('SUM(qu.noteMax) AS noteMaxEvaluation')
            ->innerJoin('e.quiz', 'q')
            ->innerJoin('q.questions', 'qu')
            ->where('e = :eval')
            ->setParameter('eval', $evaluation)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findMoyenneClasse($evaluation): float
    {
        return $this->createQueryBuilder('e')
            ->select('AVG(c.note) AS moyenneClasse')
            ->innerJoin('e.copies', 'c')
            ->where('e = :eval')
            ->setParameter('eval', $evaluation)
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findElevePos($evaluation, $idUser): int
    {
        $q = $this->createQueryBuilder('e')
            ->select('u.id')
            ->innerJoin('e.copies', 'c')
            ->innerJoin('c.user', 'u')
            ->where('e = :eval')
            ->setParameter('eval', $evaluation)
            ->orderBy('c.note', 'DESC')
            ->getQuery()
            ->getResult();
        return (array_search(['id'=>$idUser], $q) + 1);
    }

    public function findNbElevesEvaluation($evaluation): int
    {
        return $this->createQueryBuilder('e')
            ->select('COUNT(u) AS nbEleves')
            ->innerJoin('e.formation', 'f')
            ->innerJoin('f.users', 'u')
            ->where('e = :eval AND u.roles LIKE :role')
            ->setParameter('eval', $evaluation)
            ->setParameter('role', '%"ROLE_ELEVE"%')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function findEvaluationsToCorrect(User $formateur) : array
    {
        return $this->createQueryBuilder('e')
            ->select('e.id', 'f.libelle', 'q.titre', 'e.dateFin')
            ->innerJoin('e.formation', 'f')
            ->innerJoin('e.quiz', 'q')
            ->where('e.estCloture = 0 AND e.dateFin < :date AND q.formateur = :form')
            ->setParameter('form', $formateur)
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function findComingEvaluationsFormateur(User $formateur): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.id', 'f.libelle', 'q.titre', 'e.dateDebut')
            ->innerJoin('e.formation', 'f')
            ->innerJoin('e.quiz', 'q')
            ->where('e.dateDebut > :dateDebut AND q.formateur = :form')
            ->setParameter('form', $formateur)
            ->setParameter('dateDebut', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function findComingEvaluationsEleve(User $eleve): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.id', 'f.libelle', 'q.titre', 'e.dateDebut')
            ->innerJoin('e.formation', 'f')
            ->innerJoin('e.quiz', 'q')
            ->where('e.dateDebut > :date AND e.formation IN (:formations)')
            ->setParameter('formations', $eleve->getFormation())
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getResult();
    }

    public function findCurrentEvaluationsEleve(User $eleve): array
    {
        return $this->createQueryBuilder('e')
            ->select('e.id', 'f.libelle', 'q.titre', 'e.dateFin')
            ->innerJoin('e.formation', 'f')
            ->innerJoin('e.quiz', 'q')
            ->where('e.dateDebut <= :date AND e.dateFin >= :date AND e.formation IN (:formations)')
            ->setParameter('formations', $eleve->getFormation())
            ->setParameter('date', new \DateTime())
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Evaluation[] Returns an array of Evaluation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Evaluation
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
