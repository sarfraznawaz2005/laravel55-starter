<?php

/**
 * Used to set site's theme
 *
 * @return mixed
 */
function getThemeColor()
{
    $themes = [
        'default' => ['navColor' => 'bg-dark', 'titleColor' => '#d0d0d0', 'textColor' => ''],
        'dark' => ['navColor' => 'bg-dark', 'titleColor' => '#494E54', 'textColor' => 'text-white'],
        'gray' => ['navColor' => 'bg-gray', 'titleColor' => '#7B838A', 'textColor' => 'text-white'],
        'purple' => ['navColor' => 'bg-purple', 'titleColor' => '#7E55C7', 'textColor' => 'text-white'],
        'blue' => ['navColor' => 'bg-blue', 'titleColor' => '#1A89FF', 'textColor' => 'text-white'],
        'green' => ['navColor' => 'bg-green', 'titleColor' => '#3EB058', 'textColor' => 'text-white'],
        'red' => ['navColor' => 'bg-red', 'titleColor' => '#E04A58', 'textColor' => 'text-white'],
        'orange' => ['navColor' => 'bg-orange', 'titleColor' => '#FD8B2C', 'textColor' => 'text-white'],
    ];

    $theme = config('main.theme') ?? 'default';

    return $themes[$theme];
}