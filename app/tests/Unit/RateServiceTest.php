<?php

namespace App\Tests\Unit;

use App\Entity\CurrencyRatio;
use App\Repository\CurrencyRatioRepository;
use App\Service\Rate\RateInterface;
use App\Service\Rate\RateService;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Cache\Adapter\NullAdapter;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class RateServiceTest extends KernelTestCase
{
    /**
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
    }

    /**
     * @return void
     */
    public function testRatesCalculation()
    {
        $repositoryMock = $this->getCurrencyRatioRepositoryMock();
        $repositoryMock->expects($this->atLeast(2))
            ->method('findAll')
            ->willReturn([
                new CurrencyRatio('USD', 'USD', 1),
                new CurrencyRatio('USD', 'EUR', 0.93),
                new CurrencyRatio('USD', 'GBP', 0.81),
            ]);
        $service = $this->getService($repositoryMock);
        $rate1 = $service->getExchangeRate('USD', 'EUR');
        $rate2 = $service->getExchangeRate('EUR', 'USD');
        $rate3 = $service->getExchangeRate('USD', 'GBP');
        $rate4 = $service->getExchangeRate('EUR', 'GBP');

        $this->assertEquals(0.93, $rate1);
        $this->assertEquals(1 / 0.93, $rate2);
        $this->assertEquals(0.81, $rate3);
        $this->assertEquals(0.81 / 0.93, $rate4);
    }

    private function getService(MockObject $repository): RateInterface
    {
        return new RateService($repository, new NullAdapter());
    }

    /**
     * @return MockObject
     */
    private function getCurrencyRatioRepositoryMock(): MockObject
    {
        return $this->createMock(CurrencyRatioRepository::class);
    }
}