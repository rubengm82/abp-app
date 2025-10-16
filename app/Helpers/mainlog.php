<?php

namespace App\Helpers;

class mainlog
{
    /**
     * Log a message with the 'abp' keyword prefix to syslog and terminal
     * 
     * @param string $message The message to log
     * @param int $priority The log priority level (default: LOG_INFO)
     * @param string $color The color for terminal output (default: 'white')
     * @return void
     */
    public static function log(string $message, int $priority = LOG_INFO, string $color = 'white'): void
    {
        // Log to syslog
        syslog($priority, "abp -> " . $message);
        
        // Color mapping dictionary
        $colors = [
            'white'   => "\033[1;37m",  // Bright white
            'lime'  => "\033[38;5;46m",  // Green (very bright lime)
            'red'     => "\033[1;31m",  // Bright red
            'blue'    => "\033[1;34m",  // Bright blue
            'yellow'  => "\033[1;33m",  // Bright yellow
            'cyan'    => "\033[1;36m",  // Bright cyan
            'magenta' => "\033[1;35m",  // Bright magenta
            'orange'  => "\033[38;5;208m", // Orange (256 color)
            'purple'  => "\033[38;5;93m",  // Purple (256 color)
            'pink'    => "\033[38;5;213m", // Pink (256 color)
            'gray'    => "\033[1;30m",  // Bright black (gray)
        ];
        
        // Log to terminal with timestamp and selected color
        $timestamp = date('Y-m-d H:i:s');
        $selectedColor = $colors[$color] ?? $colors['white'];  // Default to white if color not found
        $limeColor = "\033[38;5;46m";  // Lime color for "abp ->"
        $resetColor = "\033[0m";  // Reset to default color
        
        $terminalMessage = "{$selectedColor}{$timestamp} {$limeColor}abp -> {$selectedColor}{$message}{$resetColor}";
        error_log($terminalMessage);
    }
}

