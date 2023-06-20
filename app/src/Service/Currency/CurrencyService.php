<?php

declare(strict_types=1);

namespace App\Service\Currency;

use App\Dto\Request\CurrencyRatioDto;
use App\Repository\CurrencyRatioRepository;
use App\Service\Rate\RateInterface;

class CurrencyService implements CurrencyInterface
{
    public function __construct(
        private readonly CurrencyRatioRepository $currencyRatio,
        private readonly RateInterface $rate
    )
    {
    }

    public function setRatio(CurrencyRatioDto $currencyRatio): void
    {
        $this->currencyRatio->setRatio($currencyRatio);
        $this->rate->resetRatesCache();
    }
}