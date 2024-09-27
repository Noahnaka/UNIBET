<?php

require_once "Banco.php";

class Cadastro implements JsonSerializable{
    public function jsonSerialize()
    {
        $respostaPadrao = new stdClass();
        $respostaPadrao->email = $this->getEmail();
        $respostaPadrao->id = $this->getId();
        return $respostaPadrao;
    }


    public function cadastro()
    {
        $conexao = Banco::getConexao();
        $sql = "INSERT INTO informacao_do_login 
        (usuario_nome, usuario_email, usuario_senha, usuario_telefone, usuario_nascimento)
         VALUES (?, ?, MD5(?), ?, ?)";
        $prepareSQL = $conexao->prepare($sql);
        $prepareSQL->bind_param("sssss", $this->Nome, $this->Email, $this->senha,$this->Telefone, $this->Nascimento);
        $executar = $prepareSQL->execute();
        $prepareSQL->close();

        if ($executar) {
            $this->id = $conexao->insert_id; 
        }
    
        return $executar;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome()
    {
        return $this->Nome;
    }

    public function setNome($nome)
    {
        $this->Nome = $nome;

        return $this;
    }
    public function getNascimento()
    {
        return $this->Nascimento;
    }

    public function setNascimento($nascimento)
    {
        $this->Nascimento = $nascimento;

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

    public function getTelefone()
    {
        return $this->Telefone;
    }

    public function setTelefone($telefone)
    {
        $this->Telefone = $telefone;

        return $this;
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
}