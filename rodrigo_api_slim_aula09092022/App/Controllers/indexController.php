<?php

namespace App\Controllers;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


class indexController
{

    public function index(Request $request, Response $response, array $args)
    {
        $response->getBody()->write("Hello, " . $args['name']);

        return $response;
    }
}