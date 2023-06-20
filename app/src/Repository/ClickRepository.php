<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Click;
use App\Entity\ClickRewardRate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClickRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Click::class);
    }

    /**
     * @param int $campaignId
     * @param ClickRewardRate $rate
     * @return Click
     */
    public function saveClick(int $campaignId, ClickRewardRate $rate): Click
    {
        $click = new Click();
        $click
            ->setCampaignId($campaignId)
            ->setCurrency($rate->getCurrency())
            ->setReward($rate->getRate());

        $entityManager = $this->getEntityManager();
        $entityManager->persist($click);
        $entityManager->flush();

        return $click;
    }

    public function getClicksGroupedByCurrency(int $campaignId): array
    {
        $queryBuilder = $this->createQueryBuilder('c')
            ->select('c.currency', 'SUM(c.reward) AS totalReward')
            ->where('c.campaignId = :campaignId')
            ->groupBy('c.currency')
            ->setParameter('campaignId', $campaignId);

        return $queryBuilder->getQuery()->getResult();
    }
}