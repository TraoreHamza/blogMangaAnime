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

    public function findByFilters(array $filters): array
    {
        $qb = $this->createQueryBuilder('m');

        if (!empty($filters['name'])) {
            $qb->andWhere('m.name LIKE :name')
                ->setParameter('name', '%' . $filters['name'] . '%');
        }
        if (!empty($filters['genre'])) {
            $qb->andWhere('m.genre LIKE :genre')
                ->setParameter('genre', '%' . $filters['genre'] . '%');
        }
        if (!empty($filters['year'])) {
            $qb->andWhere('m.year = :year')
                ->setParameter('year', $filters['year']);
        }
        return $qb->getQuery()->getResult();
    }
}
