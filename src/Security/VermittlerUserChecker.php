<?php
declare(strict_types=1);

namespace App\Security;

use App\Entity\VermittlerUser;
use Symfony\Component\Security\Core\Exception\LockedException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class VermittlerUserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if ($user instanceof VermittlerUser) {
            if (!$user->isAktiv()) {
                throw new LockedException('Inaktiv');
            }
            if ($user->getVermittler()->isGeloescht()) {
                throw new LockedException('Gelöscht');
            }
        }

    }

    public function checkPostAuth(UserInterface $user): void
    {
    }
}
