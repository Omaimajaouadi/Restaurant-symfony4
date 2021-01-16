<?php

namespace App\Repository;

use App\Entity\Exemple;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Exemple|null find($id, $lockMode = null, $lockVersion = null)
 * @method Exemple|null findOneBy(array $criteria, array $orderBy = null)
 * @method Exemple[]    findAll()
 * @method Exemple[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ExempleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Exemple::class);
    }

    // /**
    //  * @return Exemple[] Returns an array of Exemple objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Exemple
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
