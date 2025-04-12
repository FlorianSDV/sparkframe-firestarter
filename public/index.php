<?php
declare(strict_types=1);

use App\Controller\MainController;
use Sparkframe\Bootstrap\Globals;
use Sparkframe\Bootstrap\Router;

require_once __DIR__ . '/../src/Bootstrap/appstart.php';

// We gaan hier de bootstrapper aanzetten.
// Die is verantwoordelijk voor alles om de app werkend te krijgen
// Globale variabelen klaarzetten, Database connectie, router
// Dan vertelt de router ons welke method we moeten callen
// Die gaan we invoken.
// We doen een echo op de response.
