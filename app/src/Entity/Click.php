<?php

declare(strict_types=1);

namespace App\Entity;

use App\Repository\ClickRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;

#[ORM\Entity(repositoryClass: ClickRepository::class)]
#[Index(name: "campaign_id_idx", columns: ["campaign_id"])]
#[ORM\HasLifecycleCallbacks]
class Click
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column]
    private int $campaignId;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private float $reward;

    /**
     * The three-letter code (ISO 4217 format) for the currency.
     */
    #[ORM\Column(length: 3)]
    private string $currency;

    #[ORM\Column(type: 'datetime')]
    private \DateTime $createdAt;

    /**
     * @return mixed
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): self
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->setCreatedAtValue();
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getCampaignId(): int
    {
        return $this->campaignId;
    }

    /**
     * @param int $campaignId
     * @return $this
     */
    public function setCampaignId(int $campaignId): self
    {
        $this->campaignId = $campaignId;

        return $this;
    }

    /**
     * @return float
     */
    public function getReward(): float
    {
        return $this->reward;
    }

    /**
     * @param float $reward
     * @return $this
     */
    public function setReward(float $reward): self
    {
        $this->reward = $reward;

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