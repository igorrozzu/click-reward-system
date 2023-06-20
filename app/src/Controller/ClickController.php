<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\Request\ClickRegistrationDto;
use App\Service\Click\ClickInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/2023-06')]
class ClickController extends AbstractController
{
    public function __construct(private readonly ClickInterface $click)
    {
    }

    #[Route('/click', name: 'register_click', methods: ['POST'])]
    public function registerClick(
        #[MapRequestPayload] ClickRegistrationDto $clickRegistration
    ): JsonResponse
    {
        try {
            $click = $this->click->registerClick($clickRegistration);
            return $this->json([
                'status' => Response::HTTP_OK,
                'data' => $click
            ]);
        } catch (\Exception) {
            return $this->json([
                'status' => Response::HTTP_INTERNAL_SERVER_ERROR
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}