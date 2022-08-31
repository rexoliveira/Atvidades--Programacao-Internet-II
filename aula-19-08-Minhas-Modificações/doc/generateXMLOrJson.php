<?php
$con = mysqli_connect("localhost", "root", "", "ProgWebII");
/*
* Banco: ProgWebII
* Tabela: customers(customerid, companyname, contactname, address, city, postalcode, country)
*
*/
if( !$con ){
    echo "DB not Connected...";
}
else{
    $result = mysqli_query($con, "Select * from customers");
    if( $result ){
        // utilizo o param para identicar se o arquivo solicitado deve ser em XML (1) ou Json (2)
        if( $_GET['param'] == '1' ){
            // Monta o Xml
            $xml = new DOMDocument("1.0", "utf-8");
            // $xml->version = '1.0';
            // $xml->encoding = 'utf-8';

            $xml->formatOutput=true;    // formatOutput: Formata bem a saída com recuo e espaço extra. Isso não tem efeito
                                        // se o documento foi carregado com preserveWhitespace habilitado.

            $xmlUsuarios = $xml->createElement("users");    // Create new element node
            $xml->appendChild($xmlUsuarios);                // Adds new child at the end of the children

            while($row = mysqli_fetch_array($result)){
                $user = $xml->createElement("user");
                $xmlUsuarios->appendChild($user);
                
                $uid = $xml->createElement("customerid", $row['customerid']);
                $user->appendChild($uid);
                
                $uname = $xml->createElement("companyname", $row['companyname']);
                $user->appendChild($uname);
                
                $email = $xml->createElement("email", $row['contactname']);
                $user->appendChild($email);
            
                $address = $xml->createElement("address", $row['address']);
                $user->appendChild($address);

                $city = $xml->createElement("city", $row['city']);
                $user->appendChild($city);

                $postalcode = $xml->createElement("postalcode", $row['postalcode']);
                $user->appendChild($postalcode);

                $country = $xml->createElement("country", $row['country']);
                $user->appendChild($country);
            }
            echo "<xmp>".$xml->saveXML()."</xmp>";
            $xml->save("arquivos/report.xml");      // salvar

        } else {
            // monta o Json
            $users = [];
            while($row = mysqli_fetch_array($result)){
                $user = array("customerid" => $row['customerid'], 
                "companyname" => $row['companyname'], 
                "email" => $row['contactname'], 
                "address" => $row['address'],
                "city" => $row['city'],
                "postalcode" => $row['postalcode'],
                "country" => $row['country']);
                $users[] = $user;
            }
            $users = array("users" => $users);
            $json = json_encode($users);
            echo $json ;
            file_put_contents("arquivos/data.json", $json);     // salvar
        }
    }
    else{
        echo "error";
    }
}
?>