<?php

namespace App\Repository;

use App\Entity\Villesfr;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Villesfr|null find($id, $lockMode = null, $lockVersion = null)
 * @method Villesfr|null findOneBy(array $criteria, array $orderBy = null)
 * @method Villesfr[]    findAll()
 * @method Villesfr[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VillesfrRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Villesfr::class);
    }

    // /**
    //  * @return Villesfr[] Returns an array of Villesfr objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Villesfr
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
