<?php

namespace App\Enums;

abstract class UserTypeEnum
{
    public const SUPER_ADMIN = 'super_admin';
    public const ADMIN = 'admin';
    public const TEACHER = 'teacher';
    public const STUDENT = 'student';
    public const CENTER_MANAGER = 'center_manager';
    public const EXAMINER = 'examiner';

    public static function getConstants()
    {
        $reflection = new \ReflectionClass(self::class);

        return $reflection->getConstants();

    }//end of getConstants

}//end of enum
