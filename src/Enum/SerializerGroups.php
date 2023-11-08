<?php

namespace App\Enum;

/**
 * Not using PHP 8.2 Enums, as they generate a Enum-Instance on access
 * and are not useable in attributes.
 */
class SerializerGroups {
    public const READ_COMMON = 'common:read';
    public const READ_KUNDE = 'kunde:read';
    public const READ_ADRESSE = 'adresse:read';

    public const READ_USERLOGIN = 'userlogin:read';
}
