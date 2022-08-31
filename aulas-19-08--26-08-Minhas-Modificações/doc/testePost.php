<?php
    $conteudo = file_get_contents("php://input");

    $myArray = json_decode($conteudo,true);
    
    echo("==============================<br>");
    for ($i=0; $i < count($myArray); $i++) { 
        
        echo("Nome: ".$myArray[$i]['name']."<br>");
        echo("Tempo: ".$myArray[$i]['time']."<br>");
        echo("==============================<br>");
    }
?>