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

function buscaPergunta($numero) {
    foreach (mostraPerguntas() as $index => $pergunta) {
        if (!strcasecmp($pergunta[0], $numero)) {
            return ['index' => $index, 'pergunta' => $pergunta];
        }
    }
    return null;
}

header('Content-Type: application/json');

$numero = isset($_GET['numero']) ? $_GET['numero'] : null;
$resultado = buscaPergunta($numero);

if ($resultado) {
    echo json_encode($resultado);
} else {
    echo json_encode(['pergunta' => null]);
}

