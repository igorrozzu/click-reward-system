<?php

declare(strict_types=1);

namespace App\Service\Click;

use App\Dto\ClickDto;
use App\Dto\Request\ClickRegistrationDto;

interface ClickInterface
{
    public function registerClick(ClickRegistrationDto $clickRegistration): ClickDto;
}