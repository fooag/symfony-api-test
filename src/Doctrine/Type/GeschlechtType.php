<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;
use App\Common\Geschlecht;

class GeschlechtType extends Type
{
    public const NAME = 'geschlecht_enum';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return "ENUM('männlich', 'weiblich', 'divers')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Geschlecht
    {
        return $value !== null ? Geschlecht::from($value) : null;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value?->value;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function requiresSQLCommentHint(AbstractPlatform $platform): bool
    {
        return true;
    }
}
