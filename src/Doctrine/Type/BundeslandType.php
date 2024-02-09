<?php

declare(strict_types=1);

namespace App\Doctrine\Type;

use App\Common\Bundesland;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\Type;

class BundeslandType extends Type
{
    public const NAME = 'bundesland_enum';

    public function getSQLDeclaration(array $column, AbstractPlatform $platform): string
    {
        return "ENUM('BW', 'BY', 'BE', 'BB', 'HB', 'HH', 'HE', 'MV', 'NI', 'NW', 'RP', 'SL', 'SN', 'ST', 'SH', 'TH')";
    }

    public function convertToPHPValue($value, AbstractPlatform $platform): ?Bundesland
    {
        return $value !== null ? Bundesland::from($value) : null;
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
