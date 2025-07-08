<?php

namespace App\Enums;

class QuestionTypeEnum
{
    const MULTIPLE_CHOICE = 'multiple_choice';
    const ESSAY = 'essay';

    public static function getConstants()
    {
        return [
            self::MULTIPLE_CHOICE,
            self::ESSAY,
        ];
    }

    public static function getLabels()
    {
        return [
            self::MULTIPLE_CHOICE => 'Trắc nghiệm',
            self::ESSAY => 'Tự luận',
        ];
    }

    public static function getLabel($type)
    {
        return self::getLabels()[$type] ?? $type;
    }
} 