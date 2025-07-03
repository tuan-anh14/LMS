<?php

if (! function_exists('is_demo_mode')) {
    /**
     * Check if the application is in demo mode.
     *
     * @return bool
     */
    function is_demo_mode() {
        return env('DEMO_MODE', false) == true;
    }
}
