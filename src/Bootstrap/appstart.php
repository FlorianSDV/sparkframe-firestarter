<?php
declare(strict_types=1);

namespace App\Bootstrap;

//todo: misschien globals voor het pad?
//todo: een class die alle nodige paden required.
use App\Controller\MainController;
use Sparkframe\Bootstrap\Globals;

require __DIR__ . '/../../vendor/autoload.php';

$bootstrapper = Bootstrapper::getInstance();

$root_dir = dirname(__DIR__, 2);
$bootstrapper->bootstrap($root_dir);

$controller = Globals::getController(MainController::class);

echo $controller->mainFunc();