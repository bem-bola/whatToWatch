<?php

namespace App\Repository;

use App\Entity\MovieSerie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method MovieSerie|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovieSerie|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovieSerie[]    findAll()
 * @method MovieSerie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovieSerieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovieSerie::class);
    }


    public function search($title) {
        return $this->createQueryBuilder('movie')
            ->andWhere('movie.title LIKE :title')
            ->setParameter('title', '%'.$title.'%')
            ->getQuery()
            ->execute();
    }

    public function searchFilter($genreFilter,$platformFilter,$publishDateFilter,$typeFilter) {

        $queryBuilder =  $this->createQueryBuilder('mS')
                            ->addSelect("CONCAT('/images/uploads/', mS.img_affiche) as path")
                            ->addSelect("CONCAT('/movie/serie/', mS.id) as show")
                            ->addSelect("mS.description as descr")
                            ->addSelect("mS.duree as time")
                            ->addSelect("mS.date_sortieAt as date")
                            ->addSelect("mS.type as typeFilter")
                            ->addSelect("mS.title as titre");

        if( $genreFilter !== 'none'){
            $queryBuilder
                ->join("mS.genres" ,"genres")
                ->andWhere('genres IN (:genreFilter) ')
                ->setParameter('genreFilter', [$genreFilter]);
        }
        if( $platformFilter !== 'none'){
            $queryBuilder
               ->andWhere('mS.plateforme = :platformFilter')
                ->setParameter('platformFilter', $platformFilter);
        }
        if( $publishDateFilter !== 'none'){
            $queryBuilder
                ->andWhere('mS.date_sortieAt LIKE :publishDateFilter')
                ->setParameter('publishDateFilter', '%'. $publishDateFilter.'%');
        }
        if( $typeFilter !== 'none'){
            $queryBuilder
                ->andWhere('mS.type = :typeFilter')
                ->setParameter('typeFilter', $typeFilter);
        }
        return   $queryBuilder->getQuery()->getArrayResult();
    }


    // /**
    //  * @return MovieSerie[] Returns an array of MovieSerie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?MovieSerie
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

}



