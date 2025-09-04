<?php

namespace App\Repository;

use App\Entity\MangaAnime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MangaAnime>
 */
class MangaAnimeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MangaAnime::class);
    }

    //    /**
    //     * @return MangaAnime[] Returns an array of MangaAnime objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('m.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?MangaAnime
    //    {
    //        return $this->createQueryBuilder('m')
    //            ->andWhere('m.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    // App\Repository\MangaAnimeRepository.php


    public function findByGenreAndType(?string $genre, ?string $type): array
    {
        $qb = $this->createQueryBuilder('m');

        if ($genre) {
            $qb->andWhere('m.genre = :genre')
                ->setParameter('genre', $genre);
        }

        if ($type) {
            $qb->andWhere('m.type = :type')
                ->setParameter('type', $type);
        }

        return $qb->getQuery()->getResult();
    }


    public function searchByTitle(string $query): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.title LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
