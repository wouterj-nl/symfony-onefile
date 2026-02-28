<?php

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Attribute\Route;

require_once __DIR__.'/vendor/autoload_runtime.php';

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    #[Route('/')]
    public function home(): Response
    {
        $loc = count(file(__FILE__));

        return new Response(<<<EOF
            <!doctype html>
            <title>Symfony 1 file challenge</title>
            <h1>Symfony 1 file challenge: {$loc} lines</h1>
            EOF);
    }
}

return function (array $context) {
    $kernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);

    return 'cli' === PHP_SAPI ? new Application($kernel) : $kernel;
};
