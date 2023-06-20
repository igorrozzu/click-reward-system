<?php

declare(strict_types=1);

namespace App\Repository;

use App\Dto\Request\CurrencyRatioDto;
use App\Entity\CurrencyRatio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CurrencyRatioRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CurrencyRatio::class);
    }

    /**
     * @param CurrencyRatioDto $ratioDto
     * @return void
     */
    public function setRatio(CurrencyRatioDto $ratioDto): void
    {
        $this->getEntityManager()
            ->createQueryBuilder()
            ->update($this->_entityName, 'c')
            ->set('c.ratio', $ratioDto->ratio)
            ->where('c.targetCurrency = :currency')
            ->setParameter('currency', $ratioDto->currency)
            ->getQuery()
            ->execute();
    }
}