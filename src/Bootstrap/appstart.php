<?php
declare(strict_types=1);

namespace App\Bootstrap;

use Sparkframe\Request\RequestHandler;

require __DIR__ . '/../../vendor/autoload.php';

try {
    $root_dir = dirname(__DIR__, 2);
    $bootstrapper = Bootstrapper::getInstance();
    
    $bootstrapper->initializeGlobals($root_dir);
    $database_info_collection = new DatabaseInfoCollection();
    $bootstrapper->bootstrap($database_info_collection);

    $bootstrapper->startSession();

    $requestHandler = new RequestHandler();

    $requestHandler->handle();
} catch (\Exception $e) {
    // Add here your own error handling. 
    // Don't show error messages in production environments.
    echo "<pre>";
    var_dump($e);
    echo "</pre>";
} catch (\Throwable $throwable) {
    // Add here your own error handling. 
    // Don't show error messages in production environments.
    echo "<pre>";
    var_dump($throwable);
    echo "</pre>";
}
