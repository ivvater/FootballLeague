<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ValidationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $status = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        if ($event->getException() instanceof UniqueConstraintViolationException) {
            $status = JsonResponse::HTTP_BAD_REQUEST;
        } elseif ($event->getException() instanceof ValidationException) {
            $status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        }

        $response =  new JsonResponse(
            [
                'message' => $event->getException()->getMessage()
            ],
            $status
        );

        $event->setResponse($response);
    }
}
