<?php

declare(strict_types=1);

namespace App\Dto;

use App\Entity\Click;

readonly class ClickDto
{
    public function __construct(
        public int $clickId,
        public BalanceDto $balance,
    ) {
    }

    public static function fromModel(Click $click): self
    {
        return new ClickDto(
            $click->getId(),
            new BalanceDto($click->getCurrency(), $click->getReward())
        );
    }
}