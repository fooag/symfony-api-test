<?php

namespace App\Constraint;

use Attribute;
use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints;

#[Attribute]
class PasswordConstraint extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Constraints\NotBlank(),
            new Constraints\AtLeastOneOf([
                new Constraints\Regex('/[a-z]/'),
                new Constraints\Regex('/[A-Z]/'),
                new Constraints\Regex('/[0-9]/'),
                new Constraints\Regex('/[!@#$%^&*()\-_=+{};:,<.>]/'),
            ]),
            new Constraints\Length(['min' => 8]),
        ];
    }
}
