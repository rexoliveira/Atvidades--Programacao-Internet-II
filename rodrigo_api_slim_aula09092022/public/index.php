<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Routing\RouteCollectorProxy;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

/**
 * COM REDIRECIONAMENTO PARA O CONTROLE ESPECIFICO
 * GET
 */

$app->get('/hello-world', 'App\Controllers\helloWorldController:hello');
// $app->get('/', function (Request $request, Response $response, $args) {
//     $response->getBody()->write("Hello world!");
//     return $response;
// });

//Redireciona para para classe "indexController" usando o metodo "index"
$app->get('/hello/{name}', 'App\Controllers\indexController:index');
// $app->get('/hello/{name}', function ($request, $response, array $args) {
//     $response->getBody()->write("Hello, " . $args['name']);
//     return $response;
// })->setName('hello');


// =====================================================================

/**
 * SEM REDIRECIONAMENTO
 * GET
 */
$app->get('/livros', function (Request $request, Response $response) {
    $response->getBody()->write('Rota para metodo GET');

    return $response;
});

/**
 * POST
 */
$app->post('/livros', function (Request $request, Response $response)  {
    $response->getBody()->write('Rota para method POST');
    return $response;
});

// =====================================================================
/**
 * GRUPO DE ROTAS TIPO GET E POST
 * NO PADRÃO DE GRUPO SÃO DISPONIBILIZADOS PARA AS ROTAS ANINHADAS
 */
$app->group('', function (RouteCollectorProxy $group) {

    ///GET
    $group->get('/usuarios', function (Request $request, Response $response) {
            $response->getBody()->write("Usuário no grupo admin, via GET");
            $status = $response->getStatusCode();
            $response->getBody()->write(" \nGET-STATUS:$status");

            return $response;
        }
        );
        ///POST
        //Testar no POSTMAN
        $group->post('/usuarios', function (Request $request, Response $response) {
            $response->getBody()->write('POST usuário no grupo admin');
            return $response;
        }
        );
    });


// =====================================================================
/**
 * ROTA NOMEADA ->SETNAME
 */
$app->get('/oi/{name}', function ($request, $response, array $args) {
    $response->getBody()->write("Ola, " . $args['name']);
    return $response;
})->setName('nomeRota');

///CRIAR UMA ROTA PARA ESSA ROTA NOMEADA
$app->get('/meuoi', function ($request, $response, array $args) use ($app) {
    $routeParser = $app->getRouteCollector()->getRouteParser();
    echo $routeParser->urlFor('nomeRota', ['name' => 'Rodrigo']);
    return $response;
});

// =====================================================================

/**
 * RETORNA UM ARQUIVO JSON
 */
$app->get('/retornaJson', function (Request $request, Response $response) {
    //Cria um array/objeto com chave nomeada
    $data = ['name' => 'Rodrigo', 'age' => '43'];

    //Converte um OBJETO para JSON
    $json = json_encode($data);

    //Define o tipo de conteudo
    $novoResponse = $response->withHeader('Content-type', 'application/json');

    //Escreve no CORPO da RESPOSTA um OBJETO conevrtido para JSON
    $novoResponse->getBody()->write($json);

    //Define estatus conteudo ok e criado -201
    return $novoResponse->withStatus(201);
});

// =====================================================================
/**
 * RECEBE OS DADOS POR PARAMETRO E RETORNA UM JSON COM CABEÇALHO DEFINIDO
 */
$app->get('/jsonEncode', function (Request $request, Response $response) {
    //Pega os inputForm quem vem na uri 
    $params = $request->getQueryParams();

    //Passa para as variaveis
    $nome = $params['nome'];
    $sobrenome = $params['sobrenome'];

    //Cria um ARRAY para retornar o valor recebido de objeto para JSON
    $data = [
        'nome' => $nome,
        'sobrenome' => $sobrenome,
    ];

    //Define o tipo de como JSON
    $novoResponse = $response->withHeader('Content-type', 'application/json');
    //Converte um OBJETO para JSON    
    $json = json_encode($data);

    //Escreve no CORPO da RESPOSTA um OBJETO conevrtido para JSON
    $novoResponse->getBody()->write($json);

    return $novoResponse;
});

// =====================================================================
//Testar no "POSTMAN" no "Body" tipo "form/data"
//Passando por formulario
/**
 * RECEBE TIPO FORM/DATA
 * RETORNA PARA CORPO COMO TEXTO
 * TESTAR NO "POSTMAN" NO "BODY" TIPO "FORM/DATA"(PASSANDO POR FORMULARIO)
 */
$app->post('/form', function(Request $request, Response $response){
    //Pega os argumentos enviados pelo formulario- "form/data"
    //Cast para tipo ARRAY
    $inputForm = (array)$request->getParsedBody();

    //Cria um corpo concatenando as informações que chegam como um ARRAY
    $body = "";
    $body .= "Nome: ". $inputForm['nome']."\n";
    $body .= "Sobrenome: ". $inputForm['sobrenome']."\n";;
    $body .= "CPF: ". $inputForm['cpf']."\n";;

    //ESCREVE NO CORPO E RETORNA
    $response->getBody()->write($body);

    return $response;
});


$app->run();