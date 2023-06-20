<?php

declare(strict_types=1);

namespace App\Entity;
use App\Repository\CurrencyRatioRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CurrencyRatioRepository::class)]
#[ORM\Table(name: "currency_ratios")]
class CurrencyRatio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;
    /**
     * The three-letter code (ISO 4217 format) for the currency.
     */
    #[ORM\Column(length: 3)]
    private string $originCurrency;
    /**
     * The three-letter code (ISO 4217 format) for the currency.
     */
    #[ORM\Column(length: 3)]
    private string $targetCurrency;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private float $ratio;

    /**
     * @param string $originCurrency
     * @param string $targetCurrency
     * @param float $ratio
     */
    public function __construct(string $originCurrency, string $targetCurrency, float $ratio)
    {
        $this->originCurrency = $originCurrency;
        $this->targetCurrency = $targetCurrency;
        $this->ratio = $ratio;
    }


    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getOriginCurrency(): string
    {
        return $this->originCurrency;
    }

    /**
     * @param string $originCurrency
     * @return $this
     */
    public function setOriginCurrency(string $originCurrency): self
    {
        $this->originCurrency = $originCurrency;

        return $this;
    }

    /**
     * @return string
     */
    public function getTargetCurrency(): string
    {
        return $this->targetCurrency;
    }

    /**
     * @param string $targetCurrency
     * @return $this
     */
    public function setTargetCurrency(string $targetCurrency): self
    {
        $this->targetCurrency = $targetCurrency;

        return $this;
    }

    /**
     * @return float
     */
    public function getRatio(): float
    {
        return $this->ratio;
    }

    /**
     * @param float $ratio
     * @return $this
     */
    public function setRatio(float $ratio): self
    {
        $this->ratio = $ratio;

        return $this;
    }
}