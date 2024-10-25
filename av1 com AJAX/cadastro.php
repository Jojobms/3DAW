<?php

function criaUsuario($usuario, $senha) {
    $listaUsuarios = mostraUsuarios(); 
    $listaUsuarios[] = [$usuario, $senha];
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
    echo $mensagemCriacao;
}


