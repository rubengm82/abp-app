<?php

namespace App\Helpers;

class mainlog
{
    /**
     * Log a message with the 'abp' keyword prefix to syslog
     * 
     * @param string $message The message to log
     * @param int $priority The log priority level (default: LOG_INFO)
     * @return void
     */
    public static function log(string $message, int $priority = LOG_INFO): void
    {
        syslog($priority, "abp -> " . $message);
    }
}

