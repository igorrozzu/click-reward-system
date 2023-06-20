<?php

declare(strict_types=1);

namespace App\Service\Campaign;

use App\Dto\BalanceDto;
use App\Dto\Request\BalanceQueryDto;

interface CampaignInterface
{
    public function getBalance(BalanceQueryDto $query): BalanceDto;
}