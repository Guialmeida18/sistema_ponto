<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Registro;

session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: tela-login.php");
    exit;
}

$registro = new Registro($_SESSION['usuario']['id']); // Passando o ID do usuário para o construtor
$historico = $registro->obterHistorico(); // Passando o ID do usuário para o método obterHistorico()

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 50px;
            margin: 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #000;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        a {
            display: inline-block;
            background-color: #000;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        a:hover {
            background-color: #333;
        }

        .back-btn {
            margin-top: 30px;
            text-align: center;
        }
    </style>
</head>
<body>

<h1>Histórico de Entrada e Saída</h1>

<table>
    <tr>
        <th>Nome do Usuário</th>
        <th>Data e Hora de Entrada</th>
        <th>Data e Hora de Saída</th>
    </tr>
    <?php foreach ($historico as $registro): ?>
        <tr>
            <td><?php echo $registro['nome_usuario']; ?></td>
            <td><?php echo $registro['data_entrada']; ?></td>
            <td><?php echo ($registro['data_saida']) ? $registro['data_saida'] : 'Ainda não saiu'; ?></td>
        </tr>
    <?php endforeach; ?>
</table>

<div class="back-btn">
    <a href="tela-boas-vindas.php">Voltar</a>
</div>

</body>
</html>

