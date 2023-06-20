<?php

declare(strict_types=1);

namespace App\Tests\Unit;

use App\Dto\BalanceDto;
use App\Dto\Request\BalanceQueryDto;
use App\Exception\CampaignException;
use App\Repository\ClickRepository;
use App\Service\Campaign\CampaignInterface;
use App\Service\Campaign\CampaignService;
use App\Service\Rate\RateInterface;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CampaignServiceTest extends KernelTestCase
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
    public function testGettingBalanceFromCampaign1WithUsdCurrency(): void
    {
        $repositoryMock = $this->getClickRepositoryMock();
        $repositoryMock->expects($this->once())
            ->method('getClicksGroupedByCurrency')
            ->with(1)
            ->willReturn([
                ['currency' => 'USD', 'totalReward' => 0.02],
                ['currency' => 'EUR', 'totalReward' => 0.005],
            ]);
        $rateMock = $this->getRateMock();
        $rateMock->expects($this->once())
            ->method('getExchangeRate')
            ->with('EUR', 'USD')
            ->willReturn(1 / 0.93);

        $service = $this->getService($repositoryMock, $rateMock);
        $balance = $service->getBalance(new BalanceQueryDto('USD', 1));

        $this->assertInstanceOf(BalanceDto::class, $balance);
        $this->assertEquals('USD', $balance->currency);
        $this->assertEquals(0.0253, $balance->amount);
    }

    /**
     * @return void
     */
    public function testGettingBalanceFromCampaign3WithGBPCurrency(): void
    {
        $repositoryMock = $this->getClickRepositoryMock();
        $repositoryMock->expects($this->once())
            ->method('getClicksGroupedByCurrency')
            ->with(3)
            ->willReturn([
                ['currency' => 'USD', 'totalReward' => 0.01],
                ['currency' => 'EUR', 'totalReward' => 0.005],
            ]);
        $rateMock = $this->getRateMock();
        $rateMock->expects($this->atLeast(2))
            ->method('getExchangeRate')
            ->withConsecutive(['USD', 'GBP'], ['EUR', 'GBP'])
            ->willReturn(0.81, 0.81 / 0.93);

        $service = $this->getService($repositoryMock, $rateMock);
        $balance = $service->getBalance(new BalanceQueryDto('GBP', 3));

        $this->assertInstanceOf(BalanceDto::class, $balance);
        $this->assertEquals('GBP', $balance->currency);
        $this->assertEquals(0.0124, $balance->amount);
    }

    /**
     * @return void
     */
    public function testNotFoundCampaign(): void
    {
        $repositoryMock = $this->getClickRepositoryMock();
        $repositoryMock->expects($this->once())
            ->method('getClicksGroupedByCurrency')
            ->with(3)
            ->willReturn([]);
        $rateMock = $this->getRateMock();
        $service = $this->getService($repositoryMock, $rateMock);

        $this->expectException(CampaignException::class);
        $this->expectExceptionMessage('Campaign is not found');

        $service->getBalance(new BalanceQueryDto('GBP', 3));
    }

    private function getService(MockObject $clickRepository, MockObject $rate): CampaignInterface
    {
        return new CampaignService($clickRepository, $rate);
    }

    /**
     * @return MockObject
     */
    private function getClickRepositoryMock(): MockObject
    {
        return $this->createMock(ClickRepository::class);
    }

    /**
     * @return MockObject
     */
    private function getRateMock(): MockObject
    {
        return $this->createMock(RateInterface::class);
    }
}