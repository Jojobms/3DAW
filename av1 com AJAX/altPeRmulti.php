<?php
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
    file_put_contents("pergeresp.txt", $dados) or die("Erro ao abrir arquivo");
}

$perguntas = mostraPerguntas();

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['indice'])) {
    $indice = $_GET['indice'];
    if (isset($perguntas[$indice])) {
        $pergunta = $perguntas[$indice];
        echo json_encode([
            'numero' => $pergunta[0],
            'pergunta' => $pergunta[1],
            'respostaA' => $pergunta[2],
            'respostaB' => $pergunta[3],
            'respostaC' => $pergunta[4],
            'respostaD' => $pergunta[5],
            'respostaCerta' => $pergunta[6]
        ]);
    } else {
        echo json_encode(["erro" => "Pergunta não encontrada"]);
    }
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $perguntas = mostraPerguntas();
    $indice = $_POST['indice'];
    $perguntas[$indice] = [$_POST['numero'], $_POST['pergunta'], $_POST['respostaA'], $_POST['respostaB'], $_POST['respostaC'], $_POST['respostaD'], $_POST['respostaCorreta']];
    savePergunta($perguntas);
    echo json_encode(["sucesso" => true]);
    exit;
}

