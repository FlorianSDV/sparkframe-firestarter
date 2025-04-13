<?php
declare(strict_types=1);

namespace App\Bootstrap;

//todo: misschien globals voor het pad?
//todo: een class die alle nodige paden required.

use Sparkframe\Request\RequestHandler;

require __DIR__ . '/../../vendor/autoload.php';

$bootstrapper = Bootstrapper::getInstance();

$root_dir = dirname(__DIR__, 2);
$bootstrapper->bootstrap($root_dir);

$requestHandler = new RequestHandler();

try {
    echo $requestHandler->handle();
} catch (\Exception $e) {
    echo "<pre>";
    var_dump($e);
    echo "</pre>";
}
