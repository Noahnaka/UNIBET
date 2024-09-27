<?php

use Firebase\JWT\MeuTokenJWT;

require_once "Model/MeuTokenJWT.php";
require_once "Model/Cadastro.php";

$cadastros = new Cadastro();
$objResposta = new stdClass();

$textoRecebido = file_get_contents("php://input");
$objJson = json_decode($textoRecebido) or die('{"msg":"formato incorreto"}');

$cadastros->setNome($objJson->cadastros->nomeCadastro);
$cadastros->setEmail($objJson->cadastros->emailCadastro);
$cadastros->setTelefone($objJson->cadastros->telefoneCadastro);
$cadastros->setSenha($objJson->cadastros->senhaCadastro);
$cadastros->setNascimento($objJson->cadastros->nascimento);

if ($cadastros->getNome() == "" or $cadastros->getEmail() == "" or $cadastros->getTelefone() == ""
or $cadastros->getSenha() == "") {
    $objResposta->cod = 1;
    $objResposta->status = false;
    $objResposta->msg = "Os campos não pode ser vazios!";

} else {
    if ($cadastros->cadastro() == true) {
        $tokenJWT = new MeuTokenJWT();
        $novoToken =  $tokenJWT->gerarToken($objClaimsToken);

        $objResposta->cod = 4;
        $objResposta->status = true;
        $objResposta->msg = "Cadastrado com successo!";
        $objResposta->Cadastros = $cadastros;
        $objResposta->token = $novoToken;
    }

}

header("Content-Type: application/json");

if ($objResposta->status == true) {
    header("HTTP/1.1 200 OK");
} else {
    header("HTTP/1.1 400 Bad Request");
}

echo json_encode($objResposta);

?>