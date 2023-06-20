<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ErrorController extends AbstractController
{
    public function show(FlattenException $exception): JsonResponse
    {
        return $this->json([
            'status' => Response::HTTP_BAD_REQUEST,
            'error' => $exception->getMessage()
        ], Response::HTTP_BAD_REQUEST);
    }
}