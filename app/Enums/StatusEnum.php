<?php

namespace App\Enums;

class StatusEnum
{
    const TODO = 'todo';
    const DOING = 'doing';
    const DONE = 'done';

    public static function values()
    {
        return [
            self::TODO,
            self::DOING,
            self::DONE,
        ];
    }
}
