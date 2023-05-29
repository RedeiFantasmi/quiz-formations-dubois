<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    public function __invoke(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if ($user instanceof UserInterface) {
            $data['username'] = $user->getUserIdentifier();
            $data['roles'] = $user->getRoles();
        }

        $event->setData($data);
    }
}