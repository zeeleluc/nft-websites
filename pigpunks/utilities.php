<?php

/**
 * return null|string
 */
if (!function_exists('env')) {
    function env (string $key)
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(str_replace('/pigpunks', '', __DIR__));
        $dotenv->load();

        $key = 'PIGPUNKS_' . $key;

        if (!array_key_exists($key, $_ENV)) {
            return null;
        }

        return $_ENV[$key];
    }
}

if (!function_exists('is_local')) {
    function is_local(): bool
    {
        return env('ENV') === 'local';
    }
}

if (!function_exists('is_cli')) {
    function is_cli() {
        if ( defined('STDIN') ) {
            return true;
        }
        if ( php_sapi_name() === 'cli' ) {
            return true;
        }
        if ( array_key_exists('SHELL', $_ENV) ) {
            return true;
        }
        if ( empty($_SERVER['REMOTE_ADDR']) && !isset($_SERVER['HTTP_USER_AGENT']) && count($_SERVER['argv']) > 0) {
            return true;
        }
        if ( !array_key_exists('REQUEST_METHOD', $_SERVER) ) {
            return true;
        }
        return false;
    }
}

if (!function_exists('abort')) {
    function abort(string $url = '') {
        redirect($url);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url) {

        header('Location: /' . $url);
        exit;
    }
}

function shortenString($string, $startLength = 10, $endLength = 10) {
    // Check if the string is longer than the sum of start and end lengths
    if (strlen($string) <= ($startLength + $endLength)) {
        return $string; // If it's already short, return as is
    }

    // Extract the start and end parts of the string
    $start = substr($string, 0, $startLength);
    $end = substr($string, -$endLength);

    // Return the shortened string
    return $start . '...';
}

