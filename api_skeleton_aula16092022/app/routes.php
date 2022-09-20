<?php
declare(strict_types=1);

use App\Application\Actions\Livro\ListLivrosAction;

use App\Application\Actions\User\ListUsersAction;
use App\Application\Actions\User\ViewUserAction;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;
use function PHPUnit\Framework\isEmpty;

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

        $app->delete('/user/delete/{id}', function (Request $request, Response $response, array $args) {
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

        //Passando por formulario
        /**
         * TESTAR NO "POSTMAN" NO "BODY" TIPO "FORM/DATA"(PASSANDO POR FORMULARIO)
         */
        $app->post('/user/add', function(Request $request, Response $response){
            
            //Pega os argumentos enviados pelo formulario- "form/data"
            //Cast para tipo ARRAY
            $inputForm = (array)$request->getParsedBody();


            //Verifica se os campos estão presentes
            $nome= isset($inputForm['nome'])? $inputForm['nome']:"";
            $sobrenome= isset($inputForm['sobrenome'])? $inputForm['sobrenome']:"";

            
            if($nome != "" && $sobrenome != ""){

                $pdo = $this->get('bd');
                $result = $pdo->prepare("INSERT INTO public.slimteste(nome, sobrenome)VALUES (:nome, :sobrenome)");
                $result->bindParam(':nome', $nome, PDO::PARAM_STR);
                $result->bindParam(':sobrenome', $sobrenome, PDO::PARAM_STR);
                $result->execute();

                $id = $pdo->lastInsertId();



                //Listar após inserir
                $result = $pdo->prepare("SELECT * FROM slimteste WHERE id = :id");
                $result->bindParam(':id', $id, PDO::PARAM_STR);
                $result->execute();

                $row = $result->fetch(PDO::FETCH_ASSOC);
            
                if ($id) {
                    //Imprime o resultado usuario criado
                    $body = "Usuário criado!\n";
                    $body .= "ID: $id\n";
                    $body .= "Nome: ". $row['nome']."\n";
                    $body .= "Sobrenome: ". $row['sobrenome']."\n";
                } else {
                    $body = "Erro ao criar o usuário\n";
                }
            //ESCREVE NO CORPO E RETORNA
            $response->getBody()->write($body);

            return $response->withStatus(201);
            
            }else{
                $body='Sem o campo "NOME" ou "SOBRENOME ou valores vazios" ';
                //ESCREVE NO CORPO E RETORNA
                $response->getBody()->write($body);
        
                return $response->withStatus(500);
            };

        });

        //Passando por formulario
        /**
         * TESTAR NO "POSTMAN" NO "BODY" TIPO "FORM/DATA"(PASSANDO POR FORMULARIO)
         */
        $app->post('/user/update', function(Request $request, Response $response){
            
            //Pega os argumentos enviados pelo formulario- "form/data"
            //Cast para tipo ARRAY
            $inputForm = (array)$request->getParsedBody();


            //Verifica se os campos estão presentes
            $id= isset($inputForm['id'])?$inputForm['id']:"";
            $nome= isset($inputForm['nome'])? $inputForm['nome']:"";
            $sobrenome= isset($inputForm['sobrenome'])? $inputForm['sobrenome']:"";
            
            $body = "";
                $pdo = $this->get('bd');    
                $result = $pdo->prepare("SELECT * FROM slimteste ORDER BY nome");
                $result->execute();

                while($row = $result->fetch(PDO::FETCH_ASSOC)){
                //Imprime o resultado usuario criado

                    $body .= "ID: ". $row['id'];
                    $body .= "======================================\n";
                    $body .= "Nome: ". $row['nome']."\n";
                    $body .= "Sobrenome: ". $row['sobrenome']."\n\n";}
                
            
            if($id != ""){

                $pdo = $this->get('bd');
                $result = $pdo->prepare("UPDATE slimteste SET nome= :nome,sobrenome= :sobrenome WHERE id= :id ");
                $result->bindParam(':id', $id);
                $result->bindParam(':nome', $nome, PDO::PARAM_STR);
                $result->bindParam(':sobrenome', $sobrenome, PDO::PARAM_STR);
                $result->execute();

                //Listar após inserir
                $result = $pdo->prepare("SELECT * FROM slimteste WHERE id = :id");
                $result->bindParam(':id', $id, PDO::PARAM_STR);
                $result->execute();

                $row = $result->fetch(PDO::FETCH_ASSOC);
                            
                    //Imprime o resultado usuario criado
                    $body = "Atualizar Usuario!\n";
                    $body .= "ID: $id\n";
                    $body .= "Nome: ". $row['nome']."\n";
                    $body .= "Sobrenome: ". $row['sobrenome']."\n";
               
            //ESCREVE NO CORPO E RETORNA
            $response->getBody()->write($body);

            return $response->withStatus(201);
            
            }else{
                $body.='Sem o campo "ID" ou valor vazio" ';
                //ESCREVE NO CORPO E RETORNA
                $response->getBody()->write($body);
        
                return $response->withStatus(500);
            };

        });




     /* $app->group('/users', function (Group $group) {
     $group->get('', ListUsersAction::class);
     $group->get('/{id}', ViewUserAction::class);
     });
     $app->group('/livros', function (Group $group) {
     $group->get('', ListLivrosAction::class);
     // $group->get('/{id}', ViewUserAction::class);
     }); */


    };