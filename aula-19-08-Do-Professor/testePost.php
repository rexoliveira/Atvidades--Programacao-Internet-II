<?php

    $conteudo = file_get_contents("php://input");
    echo ($conteudo . "</br>");

    // var_dump($_POST);

    $myArray = json_decode($conteudo);
    // var_dump($myArray[1]->name . "</br>");


    for ($i=0; $i < count($myArray); $i++) { 
        echo "Elemento " . $i . ": " . $myArray[$i]->time . " " . $myArray[$i]->name . "</br>";
    }
?>