<?php

namespace App\Enums;

abstract class ReadingTypeEnum
{
    public const INDIVIDUAL = 'individual';
    public const GROUP = 'group';

    public static function getConstants()
    {
        $reflection = new \ReflectionClass(self::class);

        return $reflection->getConstants();

    }//end of getConstants

}//end of enum
