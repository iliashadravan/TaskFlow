<?php

namespace App\Enums;

class RoleEnum
{
    const OWNER  = 'owner';
    const ADMIN  = 'admin';
    const MEMBER = 'member';
    const VIEWER = 'viewer';

    public static function values()
    {
        return [
            self::OWNER,
            self::ADMIN,
            self::MEMBER,
            self::VIEWER,
        ];
    }
}
