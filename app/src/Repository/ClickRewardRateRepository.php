<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\ClickRewardRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;

class ClickRewardRateRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ClickRewardRate::class);
    }

    /**
     * @param \DateTime $time
     * @return ClickRewardRate|null
     * @throws NonUniqueResultException
     */
    public function getOneByTime(\DateTime $time): ?ClickRewardRate
    {
        $formattedTime = $time->format('H:i:s');
        $qb = $this->createQueryBuilder('c');

        return $qb
            ->where(
                $qb->expr()->orX(
                    $qb->expr()->andX(
                        'c.from < c.to',
                        'c.from < :time',
                        'c.to >= :time'
                    ),
                    $qb->expr()->andX(
                        'c.from > c.to',
                        $qb->expr()->orX(
                            'c.from < :time',
                            'c.to >= :time'
                        )
                    )
                )
            )
            ->setParameter('time', $formattedTime)
            ->getQuery()
            ->getOneOrNullResult();
    }
}