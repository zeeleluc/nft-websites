<?php

/**
 * return null|string
 */
if (!function_exists('env')) {
    function env (string $key)
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(str_replace('/regens', '', __DIR__));
        $dotenv->load();

        $key = 'REGEN_' . $key;

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

if (!function_exists('do_spaces')) {
    function do_spaces(string $input): string
    {
        return str_replace('---', ' ', $input);
    }
}

if (!function_exists('undo_spaces')) {
    function undo_spaces(string $input): string
    {
        return str_replace(' ', '---', $input);
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
