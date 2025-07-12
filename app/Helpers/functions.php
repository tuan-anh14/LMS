<?php

if (! function_exists('is_demo_mode')) {
    /**
     * Check if the application is in demo mode.
     *
     * @return bool
     */
    function is_demo_mode()
    {
        return env('DEMO_MODE', false) == true;
    }
}

if (! function_exists('vietnam_time')) {
    /**
     * Get current time in Vietnam timezone.
     *
     * @param string $format
     * @return string
     */
    function vietnam_time($format = 'Y-m-d H:i:s')
    {
        return Carbon\Carbon::now('Asia/Ho_Chi_Minh')->format($format);
    }
}

if (! function_exists('format_vietnam_time')) {
    /**
     * Format a date/time to Vietnam timezone.
     *
     * @param string|Carbon\Carbon $datetime
     * @param string $format
     * @return string
     */
    function format_vietnam_time($datetime, $format = 'Y-m-d H:i:s')
    {
        if (is_string($datetime)) {
            $datetime = Carbon\Carbon::parse($datetime);
        }

        return $datetime->setTimezone('Asia/Ho_Chi_Minh')->format($format);
    }
}

if (! function_exists('vietnam_date')) {
    /**
     * Get current date in Vietnam timezone.
     *
     * @param string $format
     * @return string
     */
    function vietnam_date($format = 'Y-m-d')
    {
        return Carbon\Carbon::now('Asia/Ho_Chi_Minh')->format($format);
    }
}

if (! function_exists('vietnam_datetime')) {
    /**
     * Get current datetime in Vietnam timezone as Carbon instance.
     *
     * @return Carbon\Carbon
     */
    function vietnam_datetime()
    {
        return Carbon\Carbon::now('Asia/Ho_Chi_Minh');
    }
}
