<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Twig\Environment;

#[AsController]
class TodoController
{
    #[Route('/')]
    public function index(Environment $twig): Response
    {
        return new Response($twig->render('index.html.twig'));
    }
}
