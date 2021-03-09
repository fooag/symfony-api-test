<?php

declare(strict_types=1);

namespace App\DBAL\Type;

class EnumGenderType extends EnumType
{
    public const ENUM_GENDER_TYPE = 'geschlecht';

    public const STATUS_OTHER = 'divers';
    public const STATUS_FEMALE = 'männlich';
    public const STATUS_MALE = 'weiblich';

    public function getName()
    {
        return self::ENUM_GENDER_TYPE;
    }

    protected function getValues(): array
    {
        return [
            self::STATUS_OTHER,
            self::STATUS_FEMALE,
            self::STATUS_MALE,
        ];
    }
}
