<?php

function buscaUsuario($usuario) {
    foreach (mostraUsuarios() as $usuarios) {
        if (!strcasecmp($usuarios[0], $usuario)) return $usuarios;
    }
    return null;
}

function mostraUsuarios() {
    if (!file_exists("usuarios.txt")) {
        return [];
    }
    return array_map(function($linha) {
        return explode(";", trim($linha));
    }, array_filter(file("usuarios.txt"), function($linha) {
        return trim($linha) && strpos($linha, 'usuario;senha') === false;
    }));
}

$mensagemLogin = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    $usuEnc = buscaUsuario($usuario);

    if ($usuEnc) {
        if (password_verify($senha, $usuEnc[1])) {
            $mensagemLogin = "Login realizado com sucesso! Bem-vindo, $usuario!";
            session_start();
            $_SESSION['usuario'] = $usuario;
            header("Location: criarPeRmulti.php");
            exit;
        } else {
            $mensagemLogin = "Senha ou usuário incorretos.";
        }
    } else {
        $mensagemLogin = "Senha ou usuário incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Login</h1>

<section>
    <form method="POST">
        <label for="usuario">Usuário:</label>
        <input type="text" name="usuario" id="usuario" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br>

        <input type="submit" value="Entrar">
    </form>

    <p><?php echo $mensagemLogin; ?></p>
</section>

<a href="index.php">Não tem conta? Cadastre-se aqui.</a>

</body>
</html>
tbody td:hover {
    background-color: #b71c1c;

    & a{
        color: black;
    }
}
