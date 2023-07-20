<?php

namespace App\Entity\Validation;

use Attribute;
use Symfony\Component\Validator\Constraints\Compound;
use Symfony\Component\Validator\Constraints as Assert;

#[Attribute]
class Password extends Compound
{
    protected function getConstraints(array $options): array
    {
        return [
            new Assert\NotBlank(),
            new Assert\AtLeastOneOf([
                new Assert\Regex('/[a-z]/'),
                new Assert\Regex('/[A-Z]/'),
                new Assert\Regex('/[0-9]/'),
                new Assert\Regex('/[!@#$%^&*()\-_=+{};:,<.>]/'),
            ]),
            new Assert\Length(['min' => 8, 'max' => 8]),
        ];
    }
}