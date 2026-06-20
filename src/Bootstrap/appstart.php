<?php
declare(strict_types=1);

namespace App\Bootstrap;

use Sparkframe\Request\RequestHandler;

require __DIR__ . '/../../vendor/autoload.php';

try {
    $root_dir = dirname(__DIR__, 2);
    $bootstrapper = Bootstrapper::getInstance();

    // Your controller file can be anywhere. In this case we put them in /src/Controller/
    $controllers_dir = $root_dir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Controller';

    // Your view files can be anywhere. In this case we put them in /View
    $view_dir = $root_dir . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'View';

    $bootstrapper->initializeGlobals($root_dir, $controllers_dir, $view_dir);
    $database_info_collection = new DatabaseInfoCollection();
    $bootstrapper->bootstrap($database_info_collection);

    $bootstrapper->startSession();

    $requestHandler = new RequestHandler();

    $requestHandler->handle();
} catch (\Exception $e) {
    if ($e->getCode() === 404) {
        header('Location: /404');
        exit;
    }
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
