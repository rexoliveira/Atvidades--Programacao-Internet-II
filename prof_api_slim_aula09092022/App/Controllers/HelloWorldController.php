<?php
declare(strict_types=1);
 
namespace App\Controllers;
 
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
 
class HelloWorldController
{
    public function hello(ServerRequestInterface $request, ResponseInterface $response)
    {
        $response->getBody()->write('Rota do controller');
 
        return $response;
    }
}
?>