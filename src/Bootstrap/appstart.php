<?php
declare(strict_types=1);

namespace App\Bootstrap;

//todo: misschien globals voor het pad?
//todo: een class die alle nodige paden required.

use Sparkframe\Request\RequestHandler;

require __DIR__ . '/../../vendor/autoload.php';

try {
    $root_dir = dirname(__DIR__, 2);
    $bootstrapper = Bootstrapper::getInstance();

    $bootstrapper->bootstrap($root_dir);
    $database_info_collection = new DatabaseInfoCollection();

    $bootstrapper->setupDatabaseConnections($database_info_collection);

    $requestHandler = new RequestHandler();

    echo $requestHandler->handle();
} catch (\Exception $e) {
    echo "<pre>";
    var_dump($e);
    echo "</pre>";
}
