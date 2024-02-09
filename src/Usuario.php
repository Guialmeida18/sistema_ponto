<?php

namespace App;

use App\Connection;

class Usuario
{
    private $id;
    private $nome;
    private $login;
    private $senha;

    public function __construct($nome, $login, $senha)
    {
        $this->nome = $nome;
        $this->login = $login;
        $this->senha = password_hash($senha, PASSWORD_DEFAULT);
    }

    public function cadastrar()
    {
        $conexao = Connection::getConexao();
        $stmt = $conexao->prepare("INSERT INTO usuarios (nome, login, senha) VALUES (?, ?, ?)");
        $stmt->execute([$this->nome, $this->login, $this->senha]);
    }

    public static function autenticar($login, $senha)
    {
        $conexao = Connection::getConexao();
        $stmt = $conexao->prepare("SELECT * FROM usuarios WHERE login = ?");
        $stmt->execute([$login]);
        $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        } else {
            return null;
        }
    }
}
