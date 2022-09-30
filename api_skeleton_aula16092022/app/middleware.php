<?php
declare(strict_types=1);

use App\Application\Middleware\SessionMiddleware;
use Slim\App;
use App\Application\Middleware\Layer1;

return function ($app) {
    $app->add(SessionMiddleware::class);
    $app->add(Layer1::class);
};
