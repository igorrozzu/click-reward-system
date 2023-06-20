<?php

declare(strict_types=1);

namespace App\Service\Rate;

use App\Entity\CurrencyRatio;
use App\Repository\CurrencyRatioRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\CacheInterface;

readonly class RateService implements RateInterface
{
    private const RATES_CACHE_KEY = 'currency_rates_cache';

    public function __construct(
        private CurrencyRatioRepository $currencyRatioRepository,
        private CacheInterface $cache
    )
    {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getExchangeRate(string $originCurrency, string $targetCurrency): float
    {
        $rates = $this->getExchangeRates();

        return $rates[$originCurrency][$targetCurrency];
    }

    /**
     * @throws InvalidArgumentException
     */
    public function resetRatesCache(): void
    {
        $this->cache->delete(self::RATES_CACHE_KEY);
    }

    /**
     * @return array
     * @throws InvalidArgumentException
     */
    private function getExchangeRates(): array
    {
        return $this->cache->get(self::RATES_CACHE_KEY, function () {
            $rates = $this->getBaseExchangeRates();
            foreach ($rates as $baseCurrency => $baseRates) {
                foreach ($baseRates as $sourceCurrency => $rate) {
                    if ($sourceCurrency !== $baseCurrency) {
                        $rates[$sourceCurrency][$baseCurrency] = 1 / $rate;

                        foreach ($baseRates as $targetCurrency => $targetRate) {
                            if ($targetCurrency !== $baseCurrency) {
                                $rates[$sourceCurrency][$targetCurrency] = $targetRate / $rate;
                            }
                        }
                    }
                }
            }

            return $rates;
        });
    }

    /**
     *
     * @return array
     */
    private function getBaseExchangeRates(): array
    {
        $pairs = $this->currencyRatioRepository->findAll();

        $rates = [];
        foreach ($pairs as $pair) {
            /**@var CurrencyRatio $pair*/
            $originCurrency = $pair->getOriginCurrency();
            $targetCurrency = $pair->getTargetCurrency();
            if (!isset($rates[$originCurrency])) {
                $rates[$originCurrency] = [];
            }

            $rates[$originCurrency][$targetCurrency] = $pair->getRatio();
        }

        return $rates;
    }
}