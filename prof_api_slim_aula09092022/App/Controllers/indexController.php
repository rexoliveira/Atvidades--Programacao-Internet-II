<?php

namespace App\Controllers;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class indexController{

    public function index(ServerRequestInterface $request, ResponseInterface $response, array $args) {
        $response->getBody()->write("Hello, " . $args['name']);
        return $response;
    }

};

?>