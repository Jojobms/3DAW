<?php
session_start();

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
        // Verificação sem hash, já que estamos retirando a funcionalidade de hash
        if ($senha === $usuEnc[1]) { 
            $mensagemLogin = "Login realizado com sucesso! Bem-vindo, $usuario!";
            $_SESSION['usuario'] = $usuario;
            echo json_encode(['success' => true, 'mensagem' => $mensagemLogin]);
            exit;
        } else {
            $mensagemLogin = "Senha ou usuário incorretos.";
        }
    } else {
        $mensagemLogin = "Senha ou usuário incorretos.";
    }
    echo json_encode(['success' => false, 'mensagem' => $mensagemLogin]);
}
?>
