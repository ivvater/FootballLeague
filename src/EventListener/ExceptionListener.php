<?php

declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ValidationException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        $status = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        if ($event->getException() instanceof UniqueConstraintViolationException) {
            $status = JsonResponse::HTTP_BAD_REQUEST;
        } elseif ($event->getException() instanceof ValidationException) {
            $status = JsonResponse::HTTP_UNPROCESSABLE_ENTITY;
        } elseif ($event->getException() instanceof NotFoundHttpException) {
            $status = JsonResponse::HTTP_NOT_FOUND;
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
