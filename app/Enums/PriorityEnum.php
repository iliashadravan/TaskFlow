<?php

namespace App\Enums;

class PriorityEnum
{
    const LOW = 'low';
    const MEDIUM = 'medium';
    const HIGH = 'high';

    public static function values()
    {
        return [
            self::LOW,
            self::MEDIUM,
            self::HIGH,
        ];
    }
}
