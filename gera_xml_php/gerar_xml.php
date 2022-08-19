<?php

require('array_usuarios.php');

//Cria uma nova instancia
$xml = new DOMDocument("1.0", "utf-8");

$xml->formatOutput = true;

$xmlUsuarios = $xml->createElement("users");
$xml->appendChild($xmlUsuarios);

//Percorre cada usuário
foreach ($usuarios as $chave => $valor) {
    $user = $xml->createElement("user");
    $xmlUsuarios->appendChild($user);

    //Percorre os dados de cada usuário
    foreach ($valor as $campo => $dado) {
        $temp = $xml->createElement($campo, $dado);
        $user->appendChild($temp);
    }
}

echo "<xmp>" . $xml->saveXML() . "</xmp>";
$xml->save("export.xml");

?>