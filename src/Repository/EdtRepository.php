<?php

namespace App\Repository;

use App\Entity\Edt;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Edt>
 */
class EdtRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Edt::class);
    }

    public function findEventsByWeek(int $numSemaine): array
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.week = :numSemaine')
            ->andWhere('e.flag = :flag')
            ->setParameter('numSemaine', $numSemaine)
            ->setParameter('flag', Edt::PLACE)
            ->getQuery()
            ->getResult();
    }

    public function findAvailableEventsByWeek(int $numSemaine)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.week = :numSemaine')
            ->andWhere('e.flag = :flag')
            ->setParameter('numSemaine', $numSemaine)
            ->setParameter('flag', Edt::NON_PLACE)
            ->getQuery()
            ->getResult();
    }
}
