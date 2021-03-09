<?php

declare(strict_types=1);

namespace App\Validation;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordConstraint extends Constraint
{
    public $message = 'The password must contain upper and lowercase letters, at least a digit and a special character.';
}
