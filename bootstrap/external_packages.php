<?php

$packages = [
    'UserNotification\\' => [
        'path' => dirname(__DIR__) . '/../packages/notification/src/',
        'provider' => 'UserNotification\\UserNotificationProvider',
    ],
    
    'SidebarManager\\' => [
        'path' => dirname(__DIR__) . '/../packages/sidebar-manager/src/',
        'provider' => 'SidebarManager\\SidebarManagerServiceProvider',
    ],
    'BaleBot\\' => [
        'path' => dirname(__DIR__) . '/../packages/bale-bot/src/',
        'provider' => 'BaleBot\\BaleBotProvider',
    ],
];

spl_autoload_register(function ($class) use ($packages) {

    foreach ($packages as $namespace => $config) {

        if (str_starts_with($class, $namespace)) {

            $relativeClass = substr(
                $class,
                strlen($namespace)
            );

            $file = $config['path']
                . str_replace('\\', '/', $relativeClass)
                . '.php';

            if (file_exists($file)) {
                require_once $file;
            }

            return;
        }
    }
});

return $packages;