<?php

namespace App\Enums;

abstract class AttendanceStatusEnum
{
    public const ATTENDED = 'attended';
    public const ABSENT = 'absent';
    public const EXCUSE = 'excuse';

    public static function getConstants()
    {
        $reflection = new \ReflectionClass(self::class);

        return $reflection->getConstants();

    }//end of getConstants

}//end of enum
