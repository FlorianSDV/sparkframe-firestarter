<?php

namespace App\Controller;

use Sparkframe\Attributes\Route;
use Sparkframe\Tools\RequestMethod;

class MainController extends BaseController
{
    public function __construct()
    {
        parent::__construct('Default');
    }
    public function mainFunc(): string
    {
        return 'main function';
    }

    //werkt
    #[Route('/', RequestMethod::GET)]
    public function index(): string
    {
        return 'index!';
    }
}