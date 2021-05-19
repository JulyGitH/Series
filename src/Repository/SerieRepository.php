<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Serie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Serie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Serie[]    findAll()
 * @method Serie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function findBestSeries(){

       /* //en DQL
        $entityManager = $this->getEntityManager();

        $dql = "SELECT s FROM App\Entity\Serie as s
                WHERE s.vote > 8 
                AND s.popularity > 78
                ORDER BY s.popularity DESC";

        $query = $entityManager->createQuery($dql);
        */

        //Avec le query builder
        $queryBuilder = $this->createQueryBuilder('s');

        $queryBuilder   -> andWhere('s.vote > 8')
                        ->andWhere('s.popularity > 78')
                        ->addOrderBy('s.popularity', 'DESC');

        $query = $queryBuilder->getQuery();

        //même fin :

        $query->setMaxResults(50);
        $results = $query->getResult();

        return $results;



    }

    // /**
    //  * @return Serie[] Returns an array of Serie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Serie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
