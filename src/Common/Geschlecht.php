<?php

namespace App\Common;

enum Geschlecht: string
{
    case Maennlich = 'männlich';
    case Weiblich = 'weiblich';
    case Divers = 'divers';
}