<?php

namespace App;
use PDO;
use PDOException;

class Connection
{
    private static $conexao;
    private const HOST = 'mysql';
    private const DBNAME = 'sistema_ponto';
    private const USER = 'root';
    private const PASSWORD = '1234';

    public static function getConexao()
    {
        try {
            if (!self::$conexao) {
                self::$conexao = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DBNAME, self::USER, self::PASSWORD);
                self::$conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$conexao;
        } catch (PDOException $e) {
            echo 'Erro: ' . $e->getMessage();
            exit;
        }
    }
}