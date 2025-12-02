<?php

namespace App\Enums;

enum LeaveTypeEnum: string
{
    case SICK_LEAVE = 'sick_leave';
    case VACATION_LEAVE = 'vacation_leave';
    case BEREAVEMENT_LEAVE = 'bereavement_leave';
    case CASUAL_LEAVE = 'casual_leave';

    public function getLabel(): string
    {
        return match ($this) {
            self::SICK_LEAVE => 'Sick Leave',
            self::VACATION_LEAVE => 'Vacation Leave',
            self::BEREAVEMENT_LEAVE => 'Bereavement Leave',
            self::CASUAL_LEAVE => 'Casual Leave',
        };
    }

    public static function getValues(): array
    {
        return array_reduce(self::cases(), function ($carry, $case) {
            $carry[$case->value] = $case->getLabel();
            return $carry;
        }, []);
    }
}
