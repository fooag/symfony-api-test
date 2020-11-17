<?php


namespace App\Validator\Constraints;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class PasswordConstraintValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint): void
    {
        if(
            $this->isMinimumCharacters($value) &&
            $this->containsLowercase($value) &&
            $this->containsUppercase($value) &&
            $this->containsNumber($value) &&
            $this->containsSpecialCharacter($value)
        ) {
            return;
        }
        $this->context->buildViolation($constraint->message)->addViolation();
    }


    private function isMinimumCharacters($value)
    {
        return strlen($value) >= 8;
    }

    private function containsLowercase($value)
    {
        return strtoupper($value) !== $value;
    }

    private function containsUppercase($value)
    {
        return strtolower($value) !== $value;
    }

    private function containsNumber($value)
    {
        return 1 === preg_match('~[0-9]~', $value);
    }

    private function containsSpecialCharacter($value)
    {
        //TODO: check for special characters (which ones?)
        return true;
    }
}