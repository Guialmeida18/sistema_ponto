<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Usuario;

session_start();

if (isset($_SESSION['usuario'])) {
    header("Location: tela-boas-vindas.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $usuario = Usuario::autenticar($login, $senha);

    if ($usuario) {
        $_SESSION['usuario'] = $usuario;
        header("Location: tela-boas-vindas.php");
        exit;
    } else {
        $erro = "Credenciais inválidas";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
            width: 350px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        label {
            font-weight: bold;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            background-color: #007bff;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #0056b3;
        }

        .erro {
            color: red;
            text-align: center;
            font-weight: bold;
        }

        a {
            text-decoration: none;
            color: #007bff;
            text-align: center;
            transition: color 0.3s;
        }

        a:hover {
            color: #0056b3;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Login</h1>

    <?php if (isset($erro)): ?>
        <p class="erro"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form method="POST" action="">
        <label for="login">Login:</label>
        <input type="text" id="login" name="login" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <button type="submit">Entrar</button>
    </form>

    <p>Não tem uma conta? <a href="tela-cadastro.php">Cadastre-se aqui</a></p>
</div>
</body>
</html>
