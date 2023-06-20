<?php

declare(strict_types=1);

namespace App\Dto;

readonly class BalanceDto
{
    public function __construct(
        public string $currency,
        public float $amount,
    ) {
    }
}