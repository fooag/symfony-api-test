<?php

declare(strict_types=1);

namespace App\Common;

enum Geschlecht: string
{
    case Maennlich = 'männlich';
    case Weiblich = 'weiblich';
    case Divers = 'divers';
}