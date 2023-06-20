<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Request\CurrencyRatioDto;
use App\Service\Currency\CurrencyInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/2023-06/currency')]
class CurrencyController extends AbstractController
{
    public function __construct(private readonly CurrencyInterface $currency)
    {
    }

    #[Route('/ratio', name: 'set_ratio', methods: ['POST'])]
    public function setRatio(
        #[MapRequestPayload] CurrencyRatioDto $currencyRatio
    ): JsonResponse
    {
        try {
            $this->currency->setRatio($currencyRatio);
        } catch (\Exception) {
            return $this->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return $this->json([
            'status' => Response::HTTP_OK
        ]);
    }
}