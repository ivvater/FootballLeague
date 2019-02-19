<?php

namespace App\EventSubscriber;

use App\Controller\JwtAuthenticationInterface;
use App\Exception\NotAuthorisedException;
use App\Service\JwtAuthenticationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class TokenSubscriber
 *
 * @package App\EventSubscriber
 */
class JwtAuthenticationSubscriber implements EventSubscriberInterface
{
    private $jwtAuthService;

    public function __construct(JwtAuthenticationService $jwtAuthService)
    {
        $this->jwtAuthService = $jwtAuthService;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if ($controller[0] instanceof JwtAuthenticationInterface) {
            $token = $this->getJwtTokenFromRequest($event->getRequest());
            if ($token === null) {
                throw new NotAuthorisedException('Authorisation required', JsonResponse::HTTP_UNAUTHORIZED);
            }

            $this->jwtAuthService->validateToken($token);
        }
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::CONTROLLER => 'onKernelController',
        );
    }

    /**
     * @param Request $request
     * @return null|String
     */
    private function getJwtTokenFromRequest(Request $request): ?String
    {
        $authHeader = $request->headers->get('Authorization');
        if (strpos($authHeader, "Bearer ") !== false) {
            $token = explode(" ", $authHeader);
            if (isset($token[1])) {
                return $token[1];
            }
        }

        return null;
    }
}