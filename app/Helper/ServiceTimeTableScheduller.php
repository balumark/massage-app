<?php

namespace App\Helper;

class ServiceTimeTableScheduller
{
    const RESTRICTED_TIME = '12:00';

    const ORDINARY_START_TIME = '8:00';
    const ORDINARY_END_TIME = '11:00';

    const VIP_START_TIME = '8:00';
    const VIP_END_TIME = '17:00';

    public static function createSchedule($start_time = null, $end_time = null, $appointments = [], $only_time = false): array
    {
        $schedule = [];
        $start_time = strtotime($start_time);
        $end_time = strtotime($end_time);

        while ($start_time < $end_time) {
            $time_slot = date('H:i', $start_time);
            if ($time_slot !== self::RESTRICTED_TIME) {
                if ($only_time) {
                    $schedule[] = $time_slot;
                } else {
                    $schedule[] = [
                        'time' => $time_slot,
                        'available' => !in_array($time_slot, $appointments)
                    ];
                }
            }
            $start_time = strtotime('+1 hour', $start_time);
        }

        return $schedule;
    }

    public static function createScheduleForAuthUser($appointments = []): array
    {
        list($start_time, $end_time) = self::getScheduleTimeRange();
        return self::createSchedule($start_time, $end_time, $appointments);
    }

    public static function createScheduleForRequestValidation(): string
    {
        list($start_time, $end_time) = self::getScheduleTimeRange();
        return implode(',', self::createSchedule($start_time, $end_time, [], true));
    }

    private static function getScheduleTimeRange()
    {
        $start_time = self::ORDINARY_START_TIME;
        $end_time = self::ORDINARY_END_TIME;

        if (auth()->user()->isVip()) {
            $start_time = self::VIP_START_TIME;
            $end_time = self::VIP_END_TIME;
        }

        return array($start_time, $end_time);
    }
}
