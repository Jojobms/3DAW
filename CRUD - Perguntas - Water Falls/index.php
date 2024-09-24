<?php

function criaUsuario($usuario, $senha) {
    $listaUsuarios = mostraUsuarios(); 
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);
    $listaUsuarios[] = [$usuario, $senhaHash];
    saveUsuario($listaUsuarios);
    return "Usuário cadastrado com sucesso!";
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

function saveUsuario($listaUsuarios) {
    $dados = "usuario;senha\n";
    $dados .= implode("\n", array_map(function($usuario) {
        return implode(";", $usuario);
    }, $listaUsuarios)) . "\n";
    file_put_contents("usuarios.txt", $dados) or die("Erro ao abrir arquivo");
}

$mensagemCriacao = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $mensagemCriacao = criaUsuario($usuario, $senha);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Cadastrar Novo Usuário</h1>
<section>
    <form method="POST">
        <label for="usuario">Nome de Usuário:</label>
        <input type="text" name="usuario" id="usuario" required><br>

        <label for="senha">Senha:</label>
        <input type="password" name="senha" id="senha" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</section>
<p><?php echo $mensagemCriacao; ?></p>

<a href="login.php">Entrar</a>

</body>
</html>
