<?php

namespace App\Repository;

use App\Entity\Tirage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Tirage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Tirage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Tirage[]    findAll()
 * @method Tirage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TirageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Tirage::class);
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getActiveParticipant()
    {
        return $this->createQueryBuilder('t')
            ->join('t.participants', 'p')
            ->where('p.isValid = true AND p.isSubscribe = true AND t.isActive = true')
            ->getQuery()
            ->getSingleResult()
        ;
    }

    // /**
    //  * @return Tirage[] Returns an array of Tirage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Tirage
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
