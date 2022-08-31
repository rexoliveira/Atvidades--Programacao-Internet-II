<?php
//O arquivo recebe o Json tranformado em String do index
$conteudo = file_get_contents("php://input");

//Converte para um Objeto
$myArray = json_decode($conteudo, true);


//Cria um arquivo html e devolve para index colocar na DIV "demo"
$users = [];

//Constroi um array e com USERS
for ($i = 0; $i < count($myArray); $i++) {
    $user = array(
        "nome" => $myArray[$i]['nome'],
        "telefone" => $myArray[$i]['telefone'],
        "email" => $myArray[$i]['email'],
        "endereco" => $myArray[$i]['endereco'],
        "companhia" => $myArray[$i]['companhia'],
    );
    $users['users'][$i] = $user;
}
//Trasnforma em JSON
$json = json_encode($users);
//Grava em arquivo JSON
file_put_contents("../json/jsonServidor.json", $json); 
echo $json;


//Primeira implementação desaída
/* for ($i = 0; $i < count($myArray); $i++) {
 
 echo("<hr><hr>");
 //Gera os usuário para o arquivo index.html
 echo("Nome: " . $myArray[$i]['nome'] . "<br>");
 echo("Telefone: " . $myArray[$i]['telefone'] . "<br>");
 echo("E-mail: " . $myArray[$i]['email'] . "<br>");
 echo("Endereço: " . $myArray[$i]['endereco'] . "<br>");
 echo("Empresa: " . $myArray[$i]['companhia'] . "<br><br>");
 } */
?>