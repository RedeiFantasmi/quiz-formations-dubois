<?php

namespace App\EventListener;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

class AuthenticationSuccessListener
{
    public function __invoke(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if ($user instanceof User) {
            $data['username'] = $user->getUserIdentifier();
            $data['name'] = $user->getPrenom()[0] . '. ' . $user->getNom();
            $data['roles'] = $user->getRoles();
        }

        $event->setData($data);
    }
}