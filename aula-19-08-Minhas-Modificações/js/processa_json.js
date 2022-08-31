//Função chama o json externo
function buscarJson() {

    let ajax = new XMLHttpRequest(Cache, false);

    ajax.onload = function () {
        if (ajax.readyState == 4) {
            if (ajax.status == 200) {
                //Objeto sem aspas na CHAVE somente no VALUE ao contrário do Json
                //O parse torna o Json em OBJETO
                let dados = JSON.parse(ajax.responseText);
                //Chama a função "sendJson" passando por parametro os usuario parseados em forma de OBJETOS
                sendJson(dados);
            } else {
                //Verifica se o arquivo existe e imprime um erro
                if(ajax.status == 404){
                    var teste = '<h1 class="erro">Arquivo não encotrado!</h1>'
                }
                document.getElementById("saida").innerHTML = teste;
            }
        }
    };

    ajax.open("GET", "../json/jsonCliente.json");
    ajax.send();
}

//Função envido OBJETO
function sendJson(dados) {
    var xmlhttp = new XMLHttpRequest(); // new HttpRequest instance ;
    xmlhttp.onload = function () {
        //Recebe os dados vindos do aqruivo servidor.php
        const json = xmlhttp.responseText;
        //Formata a saída 
        document.getElementById("saida").innerHTML = JSON.stringify(JSON.parse(json),undefined,2);

    };

    //Tipo POST que envia dados para o arquivo ./servidor.php
    xmlhttp.open("POST", "./servidor.php");
    //Cabeçalho que define tipo de arquivo a ser enviado que é json
    xmlhttp.setRequestHeader("Content-Type", "application/json");

    //Pega OBJETO na variável DADOS e transforma em uma String
    myJSON = JSON.stringify(dados);

    //Envia essa String para o arquivo ./servidor.php
    xmlhttp.send(myJSON);

}