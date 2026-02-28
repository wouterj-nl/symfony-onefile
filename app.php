<?php

use App\Kernel;
use Symfony\Bundle\FrameworkBundle\Console\Application;

require_once __DIR__.'/vendor/autoload_runtime.php';

return function (array $context) {
    $kernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);

    return 'cli' === PHP_SAPI ? new Application($kernel) : $kernel;
};
