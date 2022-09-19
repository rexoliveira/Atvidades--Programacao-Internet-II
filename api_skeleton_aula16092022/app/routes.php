<?php
declare(strict_types=1);

use App\Application\Actions\Livro\ListLivrosAction;

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options('/{routes:.*}', function (Request $request, Response $response) {
            // CORS Pre-Flight OPTIONS Request Handler
            return $response;
        }
        );

        $app->get('/', function (Request $request, Response $response) {
            $pdo = $this->get('bd');
            $result = $pdo->prepare("SELECT * FROM slimteste");
            $result->execute();

            $count = $pdo->prepare("SELECT  COUNT(*) FROM slimteste ");
            $count->execute();

            // monta o Json
            $users = [];
            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                $user = array("id" => $row['id'],
                    "nome" => $row['nome'],
                    "sobrenome" => $row['sobrenome'],
                );
                $users[] = $user;
            }
            $users = array("users" => $users);
            $json = json_encode($users);
            $bytes =file_put_contents("../doc/data.json", $json);
       

            // extrai a informação do ficheiro
            $string = file_get_contents("../doc/data.json");
            // faz o decode o json para uma variavel php que fica em array
            $json = json_decode($string, true);

            // aqui é onde adiciona a nova linha com o tamanho do arquivo em BYTES
            // $json["users"]['Tamanho em bytes do aqruivo'] = $bytes;
            $json['Tamanho em bytes do aqruivo'] = $bytes;
            $json['Quantidade de usuarios cadastrados'] = $count->fetch(PDO::FETCH_ASSOC);
            $json = json_encode($json);
            file_put_contents("../doc/data.json", $json);
    
            //Apliquei tipo de dados
            $novoResponse = $response->withHeader('Content-type', 'application/json');
            $novoResponse->getBody()->write($json);
            return $novoResponse;
        }
        );

        $app->get('/user/{id}', function (Request $request, Response $response, array $args) {
            $pdo = $this->get('bd');
            $result = $pdo->prepare("SELECT * FROM slimteste WHERE id = " . $args['id']);
            $result->execute();

            $row = $result->fetch(PDO::FETCH_ASSOC);
            // monta o Json
            if ($row) {
                $user = array(
                    "id" => $row['id'],
                    "nome" => $row['nome'],
                    "sobrenome" => $row['sobrenome'],
                );
            }
            else {
                $user = array(
                    "id" => $args['id'],
                    "status" => 'usuario nao encontrado',
                );
            }
            $json = json_encode($user);
    
            //Apliquei tipo de dados
            $novoResponse = $response->withHeader('Content-type', 'application/json');
            $novoResponse->getBody()->write($json);
            return $novoResponse;
        }
        );

        $app->get('/user/delete/{id}', function (Request $request, Response $response, array $args) {
            $pdo = $this->get('bd');
            $result = $pdo->prepare("SELECT * FROM slimteste WHERE id = " . $args['id']);
            $result->execute();

            $row = $result->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                $result = $pdo->prepare("DELETE FROM slimteste WHERE id = " . $args['id']);
                $result->execute();
                $user = array(
                    "id" => $args['id'],
                    "status" => 'usuario excluido',
                );
            }
            else {
                $user = array(
                    "id" => $args['id'],
                    "status" => 'usuario nao encontrado para deletar',
                );
            }
            $json = json_encode($user);
            
    
            //Apliquei tipo de dados
            $novoResponse = $response->withHeader('Content-type', 'application/json');
            $novoResponse->getBody()->write($json);
            return $novoResponse;
        }
        );





     $app->group('/users', function (Group $group) {
     $group->get('', ListUsersAction::class);
     $group->get('/{id}', ViewUserAction::class);
     });
     $app->group('/livros', function (Group $group) {
     $group->get('', ListLivrosAction::class);
     // $group->get('/{id}', ViewUserAction::class);
     });


    };