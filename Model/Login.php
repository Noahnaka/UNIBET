<?php

require_once "Banco.php";


class Login implements JsonSerializable{
    public function jsonSerialize()
    {
        $respostaPadrao = new stdClass();
        $respostaPadrao->email = $this->getEmail();
        $respostaPadrao->id = $this->getId(); 
        return $respostaPadrao;
    }   

    public function islogin() {
        $conexao = Banco::getConexao();
        $SQL = "SELECT Id_usuario FROM informacao_do_login WHERE usuario_email = ? and usuario_senha = MD5(?);";
        $prepararSQL = $conexao->prepare($SQL);
        $prepararSQL->bind_param("ss", $this->Email, $this->senha);
        
        $executar = $prepararSQL->execute();
    
        $matrizTuplas = $prepararSQL->get_result();
        $tupla = $matrizTuplas->fetch_object();

        $this->id = $tupla->Id_usuario; 
        if ($tupla) {
            return true;
        }
    
        return false;
    }

    public function getId() {
        return $this->id; 
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
        return $this;
    }

    public function getEmail()
    {
        return $this->Email;
    }

    public function setEmail($email)
    {
        $this->Email = $email;

        return $this;
    }

}


?>