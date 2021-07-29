<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
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

    public function findBestSeries()
    {
        /*
        //en DQL
        $entityManager = $this->getEntityManager();
        $dql = "
        SELECT s 
        FROM APP\Entity\Serie s
        WHERE s.popularity > 100
        AND s.vote > 8.4
        ORDER BY s.popularity DESC
        ";
        $query = $entityManager->createQuery($dql);
        $query->setMaxResults(50);
        $result = $query->getResult();
        */
        //Version QueryBuilder
        $querBuilder = $this->createQueryBuilder('s');

        $querBuilder->innerJoin('s.seasons', 'seas')
        ->addSelect('seas');

        $querBuilder-> andWhere('s.popularity > 100');
        $querBuilder->andWhere('s.vote > 8');
        $querBuilder->addOrderBy('s.popularity','DESC');
        $query = $querBuilder->getQuery();

        $query->setMaxResults(50);

        $paginator = new Paginator($query);

        //$result = $query->getResult();
        return $paginator;
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
