<?php

declare(strict_types=1);

namespace App\Security;

use App\Entity\VermittlerUser;
use Symfony\Component\Security\Core\Exception\DisabledException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user)
    {
        if (!$user instanceof VermittlerUser) {
            return;
        }

        if ((bool) $user->getAktiv() === false || $user->getVermittler()->isGeloescht() === true) {
            // the message passed to this exception is meant to be displayed to the user
            throw new DisabledException('Your user account is disabled.');
        }
    }

    public function checkPostAuth(UserInterface $user)
    {
    }
}
