<?php

/**
 * return null|string
 */
if (!function_exists('env')) {
    function env (string $key)
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(str_replace('/weepingplebs', '', __DIR__));
        $dotenv->load();

        $key = 'WEEPINGPLEBS_' . $key;

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
if (!function_exists('snake_case')) {
    function snake_case(string $input): string
    {
        $input = strtolower($input);
        $input = preg_replace('/[^a-z0-9]+/', '_', $input);

        return trim($input, '_');
    }
}

if (!function_exists('revert_snake_case')) {
    function revert_snake_case(string $input): string
    {
        $input = str_replace('_', ' ', $input);

        return ucwords($input);
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
