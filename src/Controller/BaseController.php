<?php

declare(strict_types=1);

namespace App\Controller;

use Sparkframe\Controller\Controller;

abstract class BaseController extends Controller
{
    protected function renderPage(array $viewNames, array $data = [], string $title = 'Sparkframe Firestarter', string $activeNav = ''): void
    {
        $layoutData = array_merge($data, [
            'title' => $title,
            'activeNav' => $activeNav,
        ]);

        $this->render('partials/header', $layoutData);
        foreach ($viewNames as $viewName) {
            $this->render($viewName, $data);
        }
        $this->render('partials/footer', $layoutData);
    }

    protected function redirect_404(): void
    {
        $this->renderPage(
            viewNames: ['404'],
            title: 'Not found'
        );
    }
}
