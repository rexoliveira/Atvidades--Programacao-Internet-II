<?php
//O arquivo recebe o Json tranformado em String do index
$conteudo = file_get_contents("php://input");

//Converte para um Objeto
$myArray = json_decode($conteudo, true);


//Cria um arquivo html e devolve para index colocar na DIV "demo"

for ($i = 0; $i < count($myArray); $i++) {
    //Não é necessario
    echo("<hr>Linha[".$i+intval(1)."]<hr>");
    //Gera os usuário para o arquivo index.html
    echo("Nome: " . $myArray[$i]['nome'] . "<br>");
    echo("Telefone: " . $myArray[$i]['telefone'] . "<br>");
    echo("E-mail: " . $myArray[$i]['email'] . "<br>");
    echo("Endereço: " . $myArray[$i]['endereco'] . "<br>");
    echo("Empresa: " . $myArray[$i]['companhia'] . "<br><br>");
}
?>