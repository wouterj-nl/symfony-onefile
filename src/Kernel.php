<?php

namespace App;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Twig\Environment;
use function Symfony\Component\DependencyInjection\Loader\Configurator\{env, param};

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    #[Route('/')]
    public function index(Environment $twig): Response
    {
        return new Response($twig->render('index.html.twig'));
    }

    private function configureContainer(ContainerConfigurator $container, LoaderInterface $loader, ContainerBuilder $builder): void
    {
        $container->extension('framework', [
            'secret' => env('APP_SECRET'),
            'asset_mapper' => ['paths' => ['assets/']],
        ]);

        $container->extension('doctrine', [
            'dbal' => ['url' => env('DATABASE_URL')->resolve()],
            'orm' => [
                'mappings' => [
                    'App' => [
                        'dir' => param('kernel.project_dir').'/src/Entity',
                        'prefix' => 'App\\Entity\\',
                    ],
                ],
            ],
        ]);

        $container->services()
            ->defaults()->autowire()->autoconfigure()
            ->load('App\\', __DIR__)->exclude([__FILE__, __DIR__.'/Entity/'])
        ;
    }

    private function configureRoutes(RoutingConfigurator $routes): void
    {
        $routes->import('@LiveComponentBundle/config/routes.php')->prefix('/_components');
        $routes->import(__FILE__, 'attribute');
    }

    public function registerBundles(): iterable
    {
        return [
            new \Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new \Symfony\Bundle\TwigBundle\TwigBundle(),
            new \Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new \Symfony\UX\StimulusBundle\StimulusBundle(),
            new \Symfony\UX\TwigComponent\TwigComponentBundle(),
            new \Symfony\UX\LiveComponent\LiveComponentBundle(),
        ];
    }
}
