<?php

declare(strict_types=1);

namespace App\Service\Rate;



interface RateInterface
{
    public function getExchangeRate(string $originCurrency, string $targetCurrency): float;

    public function resetRatesCache(): void;
}