<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Attribute\Route;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    private function configureContainer(ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder): void
    {
        $container->services()
            ->defaults()
                ->autowire(true)
                ->autoconfigure(true)
            ->load('App\\', __DIR__)
      ;
    }

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
