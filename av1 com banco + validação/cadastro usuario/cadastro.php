<?php
function cadastrarUsuario($nomeUser, $emailUser, $senhaUser) {
    $conexao = new mysqli("localhost", "root", "", "3daw");

    if ($conexao->connect_error) {
        return "Erro ao conectar ao banco de dados.";
    }

    $stmt = $conexao->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $nomeUser, $emailUser, $senhaUser);
    $resultado = $stmt->execute() ? "Usuário cadastrado com sucesso!" : "Erro ao cadastrar usuário.";

    $stmt->close();
    $conexao->close();
    return $resultado;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["usuario"], $_POST["email"], $_POST["senha"])) {
    echo cadastrarUsuario($_POST["usuario"], $_POST["email"], $_POST["senha"]);
} else {
    echo "Erro: Todos os campos são obrigatórios.";
}
?>
