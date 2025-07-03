<?php

namespace App\Enums;

abstract class LectureTypeEnum
{
    public const EDUCATIONAL = 'educational';
    public const EDUCATIONAL_AND_UPBRINGING = 'educational_and_upbringing';
    public const EDUCATIONAL_AND_TAJWEED = 'educational_and_tajweed';

    public static function getConstants()
    {
        $reflection = new \ReflectionClass(self::class);

        return $reflection->getConstants();

    }//end of getConstants

}//end of enum
