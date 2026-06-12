<?php

declare(strict_types=1);

namespace App\Controller;

use Sparkframe\Attributes\Route;
use Sparkframe\Tools\RequestMethod;

class DocumentationController extends BaseController
{
    private const ALLOWED_PAGES = [
        'overview',
        'introduction',
        'application-structure',
        'configuration',
        'controllers',
        'entities',
        'features',
        'models-and-query-builder',
        'requests-and-sessions',
        'routing',
        'views'
    ];

    private const PAGE_TITLES = [
        'overview' => 'Sparkframe documentation',
        'introduction' => 'Introduction',
        'features' => 'Features',
        'application-structure' => 'Application structure',
        'configuration' => 'Configuration',
        'routing' => 'Routing',
        'controllers' => 'Controllers',
        'entities' => 'Entities',
        'models-and-query-builder' => 'Models and query builder',
        'views' => 'Views',
        'requests-and-sessions' => 'Requests and sessions',
    ];

    private const HEAD_EXTRA = <<<'HTML'
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/github.min.css" media="(prefers-color-scheme: light)">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/highlightjs/cdn-release@11.9.0/build/styles/github-dark.min.css" media="(prefers-color-scheme: dark)">
HTML;
    
    #[Route('/documentation', RequestMethod::GET)]
    #[Route('/documentation/{:str}', RequestMethod::GET)]
    public function slug(string $page_name = 'overview'): void
    {
        if (!(in_array($page_name, self::ALLOWED_PAGES))) {
            $this->redirect_404();
        }

        $pageTitle = self::PAGE_TITLES[$page_name];

        $this->renderPage(
            viewName: 'documentation/' . $page_name,
            data: [
                'currentPage' => $page_name,
                'headExtra' => self::HEAD_EXTRA,
            ],
            title: 'Sparkframe - ' . $pageTitle,
            activeNav: 'documentation'
        );
    }
}
