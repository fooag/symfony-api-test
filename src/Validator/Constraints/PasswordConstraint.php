<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class PasswordConstraint extends Constraint
{
    public $message = 'Das Passwort soll 8 Zeichen lang sein und Groß/Kleinbuchstaben sowie mind. eine Zahl und ein Sonderzeichen enthalten';
}