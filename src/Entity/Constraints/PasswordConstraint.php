<?php

declare(strict_types=1);

namespace App\Entity\Constraints;

use Attribute;
use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

#[Attribute]
class PasswordConstraint extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank(),
            // https://regex101.com/r/mFOxZ0/1
            new Assert\Regex('/(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[-+_!@#$%^&*.,?])^[^ ]+$/'),
            new Assert\Length(exactly: 8),
        ];
    }
}