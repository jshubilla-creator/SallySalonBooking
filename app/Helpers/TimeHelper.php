<?php

namespace App\Helpers;

class TimeHelper
{
    /**
     * Convert 24-hour time format to 12-hour format
     *
     * @param string $time 24-hour format time (e.g., "17:30")
     * @return string 12-hour format time (e.g., "5:30 PM")
     */
    public static function formatTo12Hour($time)
    {
        if (empty($time)) {
            return '';
        }

        // Handle different time formats
        if (strpos($time, ':') === false) {
            return $time; // Return as is if no colon found
        }

        $parts = explode(':', $time);
        $hour = (int) $parts[0];
        $minute = isset($parts[1]) ? $parts[1] : '00';

        // Convert to 12-hour format
        $period = $hour >= 12 ? 'PM' : 'AM';
        $displayHour = $hour === 0 ? 12 : ($hour > 12 ? $hour - 12 : $hour);

        return sprintf('%d:%s %s', $displayHour, $minute, $period);
    }

    /**
     * Format time range in 12-hour format
     *
     * @param string $startTime 24-hour format start time
     * @param string $endTime 24-hour format end time
     * @return string Formatted time range
     */
    public static function formatTimeRange($startTime, $endTime)
    {
        $start = self::formatTo12Hour($startTime);
        $end = self::formatTo12Hour($endTime);

        return $start . ' - ' . $end;
    }
}
