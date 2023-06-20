<?php

declare(strict_types=1);

namespace App\Service\Currency;

use App\Dto\Request\CurrencyRatioDto;

interface CurrencyInterface
{
    public function setRatio(CurrencyRatioDto $currencyRatio): void;
}