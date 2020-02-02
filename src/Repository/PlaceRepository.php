<?php

namespace App\Repository;

use App\Entity\Place;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Place|null find($id, $lockMode = null, $lockVersion = null)
 * @method Place|null findOneBy(array $criteria, array $orderBy = null)
 * @method Place[]    findAll()
 * @method Place[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlaceRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Place::class);
    }

    // /**
    //  * @return Place[] Returns an array of Place objects
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
    public function findOneBySomeField($value): ?Place
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findPlacesOfBrocanteGroupBySize($brocanteId)
    {
        return $this->createQueryBuilder('place')
            ->leftJoin('place.id_emplacement', 'emplacement')
            ->addSelect('emplacement.surface')
            ->addSelect('COUNT(place)')
            ->addSelect('SUM(place.disponible)')
            ->where('place.id_brocante = :brocanteId')
            ->groupBy('emplacement.surface')
            ->addGroupBy('place.prix')
            ->setParameter('brocanteId', $brocanteId)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $brocante
     * @param $surface
     * @param $prix
     *
     * @return Place|int
     */
    public function findPlaceDispoByBrocanteAndSizeAndPrice($brocante, $surface, $prix)
    {
        try {
            $places = $this->createQueryBuilder('place')
                ->leftJoin('place.id_emplacement', 'emplacement')
                ->select('place')
                ->where('place.id_brocante = :brocanteId')
                ->andWhere('place.prix = :prix')
                ->andWhere('emplacement.surface = :surface')
                ->andWhere('place.disponible = true')
                ->setParameter('brocanteId', $brocante)
                ->setParameter('prix', $prix)
                ->setParameter('surface', $surface)
                ->getQuery()
                ->getResult();

            return $places[0];
        } catch (NonUniqueResultException $e) {
            // On ne doit jamais passer par ici
            return 1;
        }
    }

    /**
     * @param $brocante
     * @param $userID
     *
     * @return Place|int
     */
    public function findPlaceByBrocanteAndUser($brocante, $userID)
    {
        try {
            return $this->createQueryBuilder('place')
                ->select('place')
                ->where('place.id_brocante = :brocante')
                ->andWhere('place.utilisateur = :utilisateur')
                ->setParameter('brocante', $brocante)
                ->setParameter('utilisateur', $userID)
                ->getQuery()
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
            return 0;
        }
    }
}
