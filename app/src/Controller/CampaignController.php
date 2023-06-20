<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Request\BalanceQueryDto;
use App\Exception\CampaignException;
use App\Service\Campaign\CampaignInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/2023-06')]
class CampaignController extends AbstractController
{
    public function __construct(private readonly CampaignInterface $campaign)
    {
    }

    #[Route('/balance', name: 'get_balance')]
    public function getBalance(
        #[MapQueryString] BalanceQueryDto $balanceQuery
    ): JsonResponse
    {
        try {
            $balance = $this->campaign->getBalance($balanceQuery);
            return $this->json([
                'status' => Response::HTTP_OK,
                'data' => $balance
            ]);
        } catch (CampaignException $e) {
            return $this->json([
                'status' => Response::HTTP_NOT_FOUND,
                'error' => $e->getMessage()
            ], Response::HTTP_NOT_FOUND);
        } catch (\Exception) {
            return $this->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}