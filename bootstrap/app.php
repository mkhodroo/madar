<?php

use BehinInit\App\Http\Middleware\Access;
use BehinLogging\Middlewares\Logging;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

require_once __DIR__ . '/external_packages.php';

spl_autoload_register(function ($class) {
    $prefix = 'Arghavan\CaseCost\\';   // namespace اصلی پکیج خودت
    $baseDir = __DIR__ . '/../packages/arghavan-case-cost/src/'; // مسیر فولدر src پکیج

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

spl_autoload_register(function ($class) {
    $prefix = 'Arghavan\OfficialOfficeTransaction\\';   // namespace اصلی پکیج خودت
    $baseDir = __DIR__ . '/../packages/arghavan-crm-official-office-transaction/src/'; // مسیر فولدر src پکیج

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

spl_autoload_register(function ($class) {
    $prefix = 'Arghavan\PettyCash\\';   // namespace اصلی پکیج خودت
    $baseDir = __DIR__ . '/../packages/arghavan-crm-petty-cash/src/'; // مسیر فولدر src پکیج

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

spl_autoload_register(function ($class) {
    $prefix = 'Arghavan\IncomesReport\\';   // namespace اصلی پکیج خودت
    $baseDir = __DIR__ . '/../packages/arghavan-crm-incomes-report/src/'; // مسیر فولدر src پکیج

    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }

    $relativeClass = substr($class, $len);
    $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if (file_exists($file)) {
        require $file;
    }
});

$app =  Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(Access::class);
        $middleware->append(Logging::class);
        $middleware->alias([
            'access' => Access::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();



return $app;
