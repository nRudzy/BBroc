<?php

namespace App\Repository;

use App\Entity\Brocante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Types\Type;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Brocante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Brocante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Brocante[]    findAll()
 * @method Brocante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BrocanteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Brocante::class);
    }

    // /**
    //  * @return Brocante[] Returns an array of Brocante objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Brocante
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Retrouver une brocante par son département
     *
     * @param $dpt
     *
     * @return mixed
     */
    public function trouveParDepartement($dpt)
    {
        dump($dpt);
        return $this->createQueryBuilder('b')
            ->leftJoin('b.lieu', 'ville')
            ->where('ville.ville_departement = :id_dpt')
            ->setParameter('id_dpt', $dpt)
            ->orderBy('b.date', 'DESC')// trie par date descendantes
            ->getQuery()
            ->getResult();
    }

    /**
     * Retrouver une brocante par sa ville
     *
     * @param $ville
     *
     * @return mixed
     */
    public function trouveParVille($ville)
    {
        return $this->createQueryBuilder('b')
            ->leftJoin('b.lieu', 'ville')
            ->where('ville.ville_id = :ville_id')
            ->setParameter('ville_id', $ville)
            ->orderBy('b.date', 'DESC')// trie par date descendantes
            ->getQuery()
            ->getResult();
    }
}
