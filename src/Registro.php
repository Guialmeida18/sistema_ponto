<?php

namespace App;

use App\Connection;


class Registro
{
    private $id;
    private $idUsuario;
    private $dataEntrada;
    private $dataSaida;

    public function __construct($idUsuario)
    {
        $this->idUsuario = $idUsuario;
    }

    public function obterHistorico()
    {
        $conexao = Connection::getConexao();
        $stmt = $conexao->prepare("SELECT registros.*, usuarios.nome AS nome_usuario FROM registros INNER JOIN usuarios ON registros.id_usuario = usuarios.id WHERE registros.id_usuario = ?");
        $stmt->execute([$this->idUsuario]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getDataSaida($datasaida)
    {
        return $this->dataSaida = $datasaida;
    }

    public function registrarEntrada()
    {
        try {
            $conexao = Connection::getConexao();
            $stmt = $conexao->prepare("INSERT INTO registros (id_usuario, data_entrada, data_saida) VALUES (?, NOW(), null)");
            $stmt->execute([$this->idUsuario]);

        } catch (\Exception $e) {
        }

    }

    public function registrarSaida()
    {
        try {
            $conexao = Connection::getConexao();
            $stmt = $conexao->prepare("UPDATE registros SET data_saida = NOW() WHERE id_usuario = ?");
            $stmt->execute([$this->idUsuario]);
        } catch (\Exception $e) {
        }
    }

    public function obterUltimoRegistro()
    {
        $conexao = Connection::getConexao();
        $stmt = $conexao->prepare("SELECT * FROM registros WHERE id_usuario = ? ORDER BY id desc ");
        $stmt->execute([$this->idUsuario]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
//    public function isSaidaRegistrada() {
//        $conexao = Connection::getConexao();
//        $stmt = $conexao->prepare("SELECT COUNT(*) FROM registros WHERE id_usuario = ? AND data_saida IS NOT NULL");
//        $stmt->execute([$this->idUsuario]);
//        $count = $stmt->fetchColumn();
//        return $count > 0;
//    }
//}