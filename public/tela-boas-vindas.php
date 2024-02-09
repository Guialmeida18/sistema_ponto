<?php


require_once __DIR__ . '/../vendor/autoload.php';

use App\Registro;
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['usuario'])) {
    header("Location: tela-login.php");
    exit;
}

// Cria uma instância do objeto de registro para o usuário atual
$registro = new Registro($_SESSION['usuario']['id']);

// Verifica se há um registro de entrada para o usuário
$registroEntrada = $registro->obterUltimoRegistro();

// Define variáveis para controlar a exibição dos botões de registro
$exibirBotaoEntrada = false;
$exibirBotaoSaida = false;

// Se não houver registro de entrada ou se $registroEntrada não for um objeto, exibe o botão de Registrar Entrada
if (!$registroEntrada || is_array($registroEntrada) || !is_object($registroEntrada) || !$registroEntrada->getDataSaida()) {
    $exibirBotaoEntrada = true;
    $exibirBotaoSaida = true;
} else {
    // Se houver registro de entrada, verifica se a data de saída está preenchida
    if (!$registroEntrada->getDataSaida()) {
        $exibirBotaoSaida = true;
    }
}

// Processamento do formulário de entrada e saída
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST['acao'])) {
        if ($_POST['acao'] === "entrada") {
            $registro->registrarEntrada();
            $exibirBotaoEntrada = false; // Após o registro de entrada, o botão não precisa ser mais exibido
        } elseif ($_POST['acao'] === "saida") {
            $registro->registrarSaida();

            $exibirBotaoSaida = false; // Após o registro de saída, o botão não precisa ser mais exibido
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Boas Vindas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: center;
        }

        h1 {
            color: #333;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        p {
            color: #555;
            margin-bottom: 2rem;
        }

        form {
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 20px;
            align-items: center;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px 24px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            font-size: 1rem;
            text-transform: uppercase;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            text-decoration: none;
            color: #007bff;
            transition: color 0.3s;
            font-size: 0.9rem;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Boas Vindas, <?php echo htmlspecialchars($_SESSION['usuario']['nome']); ?></h1>
    <p>Registre sua entrada e saída no sistema.</p>

    <?php if ($exibirBotaoEntrada): ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="acao" value="entrada">
            <button type="submit">Registrar Entrada</button>
        </form>
    <?php elseif ($exibirBotaoSaida): ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <input type="hidden" name="acao" value="saida">
            <button type="submit">Registrar Saída</button>
        </form>
    <?php endif; ?>

    <!-- Links para outras páginas -->
    <!-- Adicione seus links aqui -->

    <br>

    <!-- Link para logout -->
    <a href="logout.php">Sair</a>
</div>
</body>
</html>

