<?php

require_once '../Controllers/activateBD.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

if(verEmail($mySql, $email)){
    if(verSenha($mySql, $email, $senha)){
        header("Location: admEscolha.php?email=$email");
    }else{
        header("Location: LoginAdmin.html?error=600");
    }
}else{
    header("Location: LoginAdmin.html?error=600");
}

function verEmail($mySql, $email) {
    if ($stmt = $mySql->prepare("SELECT COUNT(*) FROM adm WHERE adm_email = ?")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($email_existe);
        $stmt->fetch();
        $stmt->close();

        return $email_existe > 0;
    } 
    return false;
}

function verSenha($mySql, $email, $senha) {
    if ($stmt = $mySql->prepare("SELECT adm_senha FROM adm WHERE adm_email = ?")) {
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($senha_existe);
        $stmt->fetch();
        $stmt->close();

        return $senha_existe > 0;
    } 
    return false;
}

?>