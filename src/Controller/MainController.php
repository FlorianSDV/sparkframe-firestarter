<?php

declare(strict_types=1);

namespace App\Controller;

use Sparkframe\Attributes\Route;
use Sparkframe\Bootstrap\Router;
use Sparkframe\Tools\RequestMethod;

class MainController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    #[Route('/', RequestMethod::GET)]
    public function index(): void
    {
        $sorted_routes = [];
        foreach (Router::getRoutes() as $request_method => $method_routes) {
            foreach ($method_routes as $method_route) {
                $sorted_routes[] = [
                    'request_method' => $request_method,
                    'method_route' => $method_route
                ];
            }
        }

        usort(
            $sorted_routes,
            static fn($a, $b) => strcmp($a['method_route']->getUriString(), $b['method_route']->getUriString())
        );
        $this->renderPage(['index'], ['sorted_routes' => $sorted_routes], 'Sparkframe Firestarter', 'home');
    }
}
