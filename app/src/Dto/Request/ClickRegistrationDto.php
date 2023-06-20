<?php

declare(strict_types=1);

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class ClickRegistrationDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'CampaignId is required')]
        public int $campaignId,
    ) {
    }
}