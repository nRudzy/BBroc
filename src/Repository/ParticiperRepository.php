<?php

namespace App\Repository;

use App\Entity\Participer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Participer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Participer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Participer[]    findAll()
 * @method Participer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParticiperRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Participer::class);
    }

    // /**
    //  * @return Participer[] Returns an array of Participer objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Participer
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function countParticipants($id_brocante)
    {
        try {
            $nbParticipants = $this->createQueryBuilder('p')
                ->select('COUNT(p.id_brocante)')
                ->where('p.id_brocante = :val')
                ->setParameter('val', $id_brocante)
                ->getQuery()
                ->getSingleScalarResult();
        } catch (NoResultException $e) {
            return 0;
        } catch (NonUniqueResultException $ex) {
            return 0;
        }

        return $nbParticipants;
    }
}
