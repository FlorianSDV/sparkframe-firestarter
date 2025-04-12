<?php

namespace App\Controller;

use Sparkframe\Attributes\Route;

class MainController extends BaseController
{
    public function mainFunc(): string
    {
        return 'main function';
    }

    #[Route('/', 'GET')]
    public function index()
    {

    }
}