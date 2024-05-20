<?php

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

use Symfony\Bundle\FrameworkBundle\Controller\TemplateController;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\{env, param};

return function (array $context) {
    return new class($context['APP_ENV'], (bool) $context['APP_DEBUG']) extends Kernel {
        use MicroKernelTrait;

        private function configureRoutes(RoutingConfigurator $routes): void
        {
            $routes->import('@LiveComponentBundle/config/routes.php')->prefix('/_components');

            $routes->add(path: '/', name: 'home')
                ->controller(TemplateController::class)
                ->defaults(['template' => 'index.html.twig']);
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
                            'dir' => dirname(__DIR__).'/src',
                            'prefix' => 'App',
                        ],
                    ],
                ],
            ]);

            $container->services()
                ->defaults()->autowire()->autoconfigure()
                ->load('App\\', dirname(__DIR__).'/src')
            ;
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
                new \Symfony\UX\Icons\UXIconsBundle(),
            ];
        }
    };
};
