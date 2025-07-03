<?php

namespace App\Enums;

abstract class AssessmentEnum
{
    public const SUPERIORITY = 'superiority';
    public const EXCELLENT = 'excellent';
    public const VERY_GOOD = 'very_good';
    public const GOOD = 'good';
    public const REPEAT = 'repeat';

    public static function getConstants()
    {
        $reflection = new \ReflectionClass(self::class);

        return $reflection->getConstants();

    }//end of getConstants

}//end of enum
