<?php

use Firebase\JWT\MeuTokenJWT;

require_once "Model/MeuTokenJWT.php";
require_once "Model/Login.php";

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg":"formato incorreto"}');

$objResposta = new stdClass();
$login = new Login();

$login->setEmail($objJson->logins->email);
$login->setSenha($objJson->logins->senha);

if ($login->getEmail() == '' OR $login->getSenha() == '') {
    $objResposta->cod = 1;
    $objResposta->status = false;
    $objResposta->msg = "Faltando informação";
} else {
    if ($login->islogin() == true) {
        $tokenJWT = new MeuTokenJWT();

        $objClaimsToken = new stdClass();
        $objClaimsToken->Email = $login->getEmail();
    
        $novoToken =  $tokenJWT->gerarToken($objClaimsToken);
      
        $objResposta->cod = 1;
        $objResposta->status = true;
        $objResposta->msg = "Login Efetuado com sucesso";
        $objResposta->login = $login;
        $objResposta->token = $novoToken;
    } 
    else {
        $objResposta->cod = 2;
        $objResposta->status = false;
        $objResposta->msg = "Login invalido";
    }
}

header("Content-Type: application/json");

if ($objResposta->status == true) {
    header("HTTP/1.1 200");
} else {
    header("HTTP/1.1 401");
}

echo json_encode($objResposta);

?>