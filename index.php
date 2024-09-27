<?php

require_once "Model/Router.php";

$roteador = new Router();

$roteador->post("/logins", function(){
   require_once "Controllers/controle_pessoas_login.php";
});

$roteador->post("/cadastros", function(){
   require_once "Controllers/controle_pessoas_cadastro.php";
});

$roteador->post("/resultados/(/+d)",function($idBolao) {
   require_once "Controllers/pontosBolao.php";
});

$roteador->run();

?>