<?php

declare(strict_types=1);

namespace App\Service\Click;

use App\Dto\ClickDto;
use App\Dto\Request\ClickRegistrationDto;
use App\Repository\ClickRepository;
use App\Repository\ClickRewardRateRepository;
use Doctrine\ORM\NonUniqueResultException;

readonly class ClickService implements ClickInterface
{
    public function __construct(
        private ClickRepository $clickRepository,
        private ClickRewardRateRepository $clickRewardRateRepository,
    )
    {
    }

    /**
     * @throws NonUniqueResultException
     */
    public function registerClick(ClickRegistrationDto $clickRegistration): ClickDto
    {
        $rate = $this->clickRewardRateRepository->getOneByTime(new \DateTime());
        $click = $this->clickRepository->saveClick($clickRegistration->campaignId, $rate);

        return ClickDto::fromModel($click);
    }
}