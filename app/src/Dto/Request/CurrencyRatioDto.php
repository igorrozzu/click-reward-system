<?php

declare(strict_types=1);

namespace App\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

readonly class CurrencyRatioDto
{
    public function __construct(
        #[Assert\NotBlank(message: 'Ratio is required')]
        #[Assert\GreaterThan(0, message: 'Ratio should be greater then 0')]
        public float $ratio,

        #[Assert\NotBlank]
        #[Assert\Choice(callback: 'getCurrencies', message: 'Not available currency')]
        public string $currency,
    ) {
    }

    /**
     * @return array
     */
    public static function getCurrencies(): array
    {
        return json_decode($_ENV['CHANGEABLE_RATIO_CURRENCIES']);
    }
}