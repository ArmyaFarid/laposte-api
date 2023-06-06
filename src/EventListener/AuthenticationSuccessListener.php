<?php

namespace App\EventListener;

use App\Entity\Employe;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;

class AuthenticationSuccessListener
{


    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $user = $event->getUser();

        if (!$user instanceof Employe) {
            return;
        }

        $data['data'] = array(
            'employeId'=>$user->getId(),
            'roles' => $user->getRoles(),
        );

        $event->setData($data);
    }
}