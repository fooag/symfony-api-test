<?php

declare(strict_types=1);

namespace App\DBAL\Query;

use App\DBAL\Query\UserScope\UserAwareScope;
use App\DBAL\Query\UserScope\VermittlerAdresseScope;
use App\DBAL\Query\UserScope\VermittlerKundeScope;
use App\DBAL\Query\UserScope\VermittlerKundeUserScope;
use App\Entity\Adresse;
use App\Entity\Kunde;
use App\Entity\KundeUser;
use App\Entity\VermittlerUser;
use Symfony\Component\Security\Core\User\UserInterface;

class CurrentUserScopeFactory
{
    public function resolveScopeForContext(UserInterface $user, string $contextClass): UserAwareScope
    {
        $isVermittlerUser = ($user instanceof VermittlerUser === true);

        if ($isVermittlerUser && $contextClass === Kunde::class) {
            return new VermittlerKundeScope();
        }

        if ($isVermittlerUser && $contextClass === Adresse::class) {
            return new VermittlerAdresseScope();
        }

        if ($isVermittlerUser && $contextClass === KundeUser::class) {
            return new VermittlerKundeUserScope();
        }

        throw new \InvalidArgumentException(
            sprintf(
                'Unsupported user type <%s> for context class <%s>.',
                get_class($user),
                $contextClass
            )
        );
    }
}
