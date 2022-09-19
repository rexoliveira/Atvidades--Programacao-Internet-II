<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteContext;
use Slim\Routing\RouteCollectorProxy;

use App\Controllers\indexController;
use App\Controllers\HelloWorldController;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();



// $app->get('/livros', function (Request $request, Response $response) {
//     $response->getBody()->write('Rota \'livros\' para method GET');
//     return $response;
// });

// $app->post('/livros', function (Request $request, Response $response)  {
//     $response->getBody()->write('Rota para method POST');
//     return $response;
// });

// Route placeholders, Optional segments

// $group->get('/usuarios', function(Request $request, Response $response){
//     $response->getBody()->write('Usuário no grupo admin, via GET');
//     return $response;
// });

// $group->post('/usuarios', function(Request $request, Response $response){
//     $response->getBody()->write('POST usuário no grupo admin');
//     return $response;
// });

// $app->group('' , function ( RouteCollectorProxy $group){
 
//     $group->get('/usuarios', function(Request $request, Response $response){
//         $response->getBody()->write('Usuário no grupo admin, via GET');
//         return $response;
//     });
 
//     $group->post('/usuarios', function(Request $request, Response $response){
//         $response->getBody()->write('POST usuário no grupo admin');
//         return $response;
//     });
// });


//      Application routes can be assigned a name. This is useful if you want to
//      programmatically generate a URL to a specific route with the RouteParser’s urlFor() 

// $app->get('/hello/{name}', function ($request, $response, array $args) {
//     $response->getBody()->write("Hello, " . $args['name']);
//     return $response;
// })->setName('hello');

// $app->get('/teste', function ($request, $response, array $args) use ($app){
//     $routeParser = $app->getRouteCollector()->getRouteParser();
//     echo $routeParser->urlFor('hello', ['name' => 'Josh'], ['example' => 'name']);
//     return $response;
// });


//      Rotas com Controller
$app->get('/hello/{name}', 'App\Controllers\indexController:index');

// $app->get('/hello-world', 'App\Controllers\HelloWorldController:hello');




// $app->get('/teste', function(Request $request, Response $response) {
//     $params = $request->getQueryParams();
//     $nome = $params['nome'];
//     $sobrenome = $params['sobrenome'];
     
//     $data = [
//         'nome' => $nome,
//         'sobrenome' => $sobrenome
//     ];
//     $response->getBody()->write(json_encode($data));

//     return $response;
// });


// $app->post('/form', function(Request $request, Response $response, array $args) {
//     $params = (array) $request->getParsedBody();
 
//     $body = "";
//     $body .= "Nome: " . $params['nome']. '<br>';
//     $body .= "Sobreome: " . $params['sobrenome']. '<br>';
//     $body .= "CPF: " . $params['cpf']. '<br>';

//     $response->getBody()->write( $body );
//     return $response;
// });



// /* Nomear rotas */
// $app->get('/hello/{name}', function ($request, $response, array $args) {
//     $response->getBody()->write("Hello, " . $args['name']);
//     return $response;
// })->setName('hello');

// $app->get('/meusite', function ($request, $response, array $args) use ($app) {
//     $routeParser = $app->getRouteCollector()->getRouteParser();
//     echo $routeParser->urlFor('hello', ['name' => 'Josh'], ['example' => 'name']);
//     return $response;
// });



//    Return Json

// $app->get('/json', function ($request, $response, array $args) {
//     $data = array('name' => 'Rob', 'age' => 40);
//     $payload = json_encode($data);
    
//     $response->getBody()->write($payload);
//     return $response
//               ->withHeader('Content-Type', 'application/json')
//               ->withStatus(201);
// });



$app->run();