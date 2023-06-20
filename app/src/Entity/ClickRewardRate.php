<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ClickRewardRateRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

#[ORM\Entity(repositoryClass: ClickRewardRateRepository::class)]
#[Index(name: "from_idx", columns: ["from"])]
#[Index(name: "to_idx", columns: ["to"])]
#[ORM\Table(name: "click_reward_rates")]
class ClickRewardRate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(name:"`from`", type: 'time')]
    private DateTime $from;

    #[ORM\Column(name:"`to`", type: 'time')]
    private DateTime $to;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private float $rate;
    /**
     * The three-letter code (ISO 4217 format) for the currency.
     */
    #[ORM\Column(length: 3)]
    private string $currency;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getFrom(): DateTime
    {
        return $this->from;
    }

    /**
     * @param DateTime $from
     * @return $this
     */
    public function setFrom(DateTime $from): self
    {
        $this->from = $from;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getTo(): DateTime
    {
        return $this->to;
    }

    /**
     * @param DateTime $to
     * @return $this
     */
    public function setTo(DateTime $to): self
    {
        $this->to = $to;

        return $this;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     * @return $this
     */
    public function setRate(float $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     * @return $this
     */
    public function setCurrency(string $currency): self
    {
        $this->currency = $currency;

        return $this;
    }
}