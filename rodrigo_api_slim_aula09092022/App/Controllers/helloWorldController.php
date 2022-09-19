<?php
declare(strict_types=1);

namespace App\Controllers;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HelloWorldController
{

    public function hello(Request $request, Response $response)
    {
        $response->getBody()->write('Rota do helloWordController');

        return $response;
    }
}