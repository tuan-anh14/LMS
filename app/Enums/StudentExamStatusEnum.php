<?php

namespace App\Enums;

abstract class StudentExamStatusEnum
{
    public const ASSIGNED_TO_EXAMINER = 'assigned_to_examiner';
    public const DATE_TIME_SET = 'date_time_set';
    public const ASSESSMENT_ADDED = 'assessment_added';

    public static function getConstants()
    {
        $reflection = new \ReflectionClass(self::class);

        return $reflection->getConstants();

    }//end of getConstants

}//end of enum
