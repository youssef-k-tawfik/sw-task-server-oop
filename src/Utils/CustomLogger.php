<?php

declare(strict_types=1);

namespace App\Utils;

/**
 * Custom logger class to log messages with colors in the terminal during development.
 * 
 * This utility is designed to enhance debugging and logging by providing
 * color-coded messages for better visibility in the terminal.
 */
class CustomLogger
{
    /**
     * Logs an informational message in green color.
     *
     * This method logs messages in green color when the application is running
     * in the development environment. In production, it logs without color.
     *
     * @param string $message The informational message to log.
     * @return void
     */
    public static function logInfo(string $message): void
    {
        // Only log with color in development environment
        $env = $_ENV['APP_ENV'] ?? 'production';
        if ($env === 'development') {
            $message = "\033[32m" . $message . "\033[0m";
        }
        error_log($message);
    }

    /**
     * Logs a variable's value in yellow color for debugging purposes.
     *
     * This method logs the provided variable's value along with the file and line
     * number from where it was called. It only logs in the development environment.
     *
     * @param string $calling_file The file from which the debug method is called.
     * @param int    $calling_line The line number in the calling file.
     * @param mixed  $var          The variable to log. Can be of any type (e.g., array, object, scalar).
     * @return void
     */
    public static function debug(
        string $calling_file,
        int $calling_line,
        mixed $var
    ): void {
        // Only log debug messages in development environment
        $env = $_ENV['APP_ENV'] ?? 'production';
        if ($env !== 'development') {
            return;
        }

        // Substring the file name to start with 'src'
        $src_pos = strpos($calling_file, 'src');
        if ($src_pos !== false) {
            $calling_file = substr($calling_file, $src_pos);
        }

        $caller = $calling_file . ':' . $calling_line ?? 'unknown file';
        error_log("\033[36mCalled from: " . $caller . "\033[0m");

        // transform the variable into a string
        if (is_array($var) || is_object($var)) {
            $var = print_r($var, true);
        }
        error_log("\033[33m" . $var . "\033[0m");
    }
}
