<?php

declare(strict_types=1);

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class BalanceQueryDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Currency is required')]
        #[Assert\Choice(callback: 'getCurrencies', message: 'Not available currency')]
        public string $currency,

        #[Assert\NotBlank(message: 'CampaignId is required')]
        public int $campaignId,
    ) {
    }

    /**
     * @return array
     */
    public static function getCurrencies(): array
    {
        return json_decode($_ENV['CURRENCIES']);
    }
}