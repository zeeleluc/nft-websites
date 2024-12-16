<?php

/**
 * return null|string
 */
if (!function_exists('env')) {
    function env (string $key)
    {
        $dotenv = \Dotenv\Dotenv::createImmutable(str_replace('/shillingx', '', __DIR__));
        $dotenv->load();

        $key = 'SHILLINGX_' . $key;

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

function calculateCompletionPercentages(array $actions, array $requiredActions): array
{
    // Initialize a results array to track progress per project
    $completion = [];

    // Loop through the actions array to count actions per project and type
    foreach ($actions as $action) {
        $project = $action['project'];
        $type = $action['type'];

        // Increment the count for the action type under the corresponding project
        if (!isset($completion[$project])) {
            $completion[$project] = [];
        }
        if (!isset($completion[$project][$type])) {
            $completion[$project][$type] = 0;
        }
        $completion[$project][$type]++;
    }

    // Calculate completion percentages
    $percentages = [];
    foreach ($requiredActions as $project => $requirements) {
        $percentages[$project] = 0;
        $totalRequired = array_sum($requirements);
        $totalCompleted = 0;

        if (isset($completion[$project])) {
            foreach ($requirements as $type => $requiredCount) {
                $completed = $completion[$project][$type] ?? 0;
                $totalCompleted += min($completed, $requiredCount);
            }
        }

        // Calculate the percentage and round it to the nearest whole number
        $percentages[$project] = (int) floor($totalRequired > 0 ? ($totalCompleted / $totalRequired) * 100 : 0);
    }

    return $percentages;
}

function calculateRemainingActions(array $actions, array $requiredActions): array
{
    // Initialize a results array to track progress per project
    $completion = [];

    // Loop through the actions array to count actions per project and type
    foreach ($actions as $action) {
        $project = $action['project'];
        $type = $action['type'];

        // Increment the count for the action type under the corresponding project
        if (!isset($completion[$project])) {
            $completion[$project] = [];
        }
        if (!isset($completion[$project][$type])) {
            $completion[$project][$type] = 0;
        }
        $completion[$project][$type]++;
    }

    // Calculate the remaining actions per project
    $remaining = [];
    foreach ($requiredActions as $project => $requirements) {
        foreach ($requirements as $type => $requiredCount) {
            // Calculate how many more actions are needed
            $completed = $completion[$project][$type] ?? 0;
            $remainingCount = $requiredCount - $completed;

            // Only include action types with remaining counts greater than 0
            if ($remainingCount > 0) {
                if (!isset($remaining[$project])) {
                    $remaining[$project] = [];
                }
                $remaining[$project][$type] = $remainingCount;
            }
        }
    }

    return $remaining;
}

