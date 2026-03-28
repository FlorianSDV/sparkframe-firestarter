<?php

declare(strict_types=1);

namespace App\Controller;

use App\Model\MainModel;
use Sparkframe\Attributes\Route;
use Sparkframe\Controller\Controller;
use Sparkframe\Tools\RequestMethod;

class MainController extends Controller
{
    public function __construct()
    {
        parent::__construct(new MainModel());
    }

    #[Route('/', RequestMethod::GET)]
    public function index(): void
    {
        $this->render('index');
    }
}
