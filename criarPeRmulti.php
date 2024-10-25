<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

function criaPerg($numero, $pergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCerta) {
    $listaPerguntas = mostraPerguntas();
    $listaPerguntas[] = [$numero, $pergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCerta];

    if (savePergunta($listaPerguntas)) {
        return "Pergunta adicionada com sucesso!";
    } else {
        return "Erro ao adicionar a pergunta.";
    }
}

function mostraPerguntas() {
    if (!file_exists("pergeresp.txt")) {
        return [];
    }
    return array_map(function($linha) {
        return explode(";", trim($linha));
    }, array_filter(file("pergeresp.txt"), function($linha) {
        return trim($linha) && strpos($linha, 'numero;pergunta;respostaA;respostaB;respostaC;respostaD;respostaCerta') === false;
    }));
}

function savePergunta($listaPerguntas) {
    $dados = "numero;pergunta;respostaA;respostaB;respostaC;respostaD;respostaCerta\n";
    $dados .= implode("\n", array_map(function($pergunta) {
        return implode(";", $pergunta);
    }, $listaPerguntas)) . "\n";

    if (!is_writable("pergeresp.txt")) {
        return "Arquivo 'pergeresp.txt' não é gravável.";
    }
    
    if (file_put_contents("pergeresp.txt", $dados) === false) {
        return "Falha ao escrever no arquivo 'pergeresp.txt'.";
    }
    
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST["numero"] ?? null;
    $pergunta = $_POST["pergunta"] ?? null;
    $respostaA = $_POST["respostaA"] ?? null;
    $respostaB = $_POST["respostaB"] ?? null;
    $respostaC = $_POST["respostaC"] ?? null;
    $respostaD = $_POST["respostaD"] ?? null;
    $respostaCerta = $_POST["respostaCerta"] ?? null;
    
    if (isset($numero, $pergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCerta)) {
        echo criaPerg($numero, $pergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCerta);
    } else {
        echo "Erro: todos os campos devem ser preenchidos.";
    }
}
