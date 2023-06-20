<?php

declare(strict_types=1);

namespace App\Service\Campaign;

use App\Dto\BalanceDto;
use App\Dto\Request\BalanceQueryDto;
use App\Exception\CampaignException;
use App\Repository\ClickRepository;
use App\Service\Rate\RateInterface;

readonly class CampaignService implements CampaignInterface
{
    private const ROUND_PRECISION = 10000;

    public function __construct(
        private ClickRepository $clickRepository,
        private RateInterface $rate
    )
    {
    }

    /**
     * @param BalanceQueryDto $query
     * @return BalanceDto
     * @throws CampaignException
     */
    public function getBalance(BalanceQueryDto $query): BalanceDto
    {
        $groupedClicks = $this->clickRepository->getClicksGroupedByCurrency($query->campaignId);
        if (!count($groupedClicks)) {
            throw new CampaignException('Campaign is not found');
        }
        $balance = $this->calculateBalance($groupedClicks, $query);

        return new BalanceDto($query->currency, $balance);
    }

    private function calculateBalance(array $groupedClicks, BalanceQueryDto $query): float
    {
        $balance = 0;
        foreach ($groupedClicks as $group) {
            if ($group['currency'] === $query->currency) {
                $balance += $group['totalReward'];
            } else {
                $rate = $this->rate->getExchangeRate($group['currency'], $query->currency);
                $balance += $group['totalReward'] * $rate;
            }
        }

        return $this->roundBalance($balance);
    }

    private function roundBalance(float $balance): float
    {
        return floor($balance * self::ROUND_PRECISION) / self::ROUND_PRECISION;
    }
}