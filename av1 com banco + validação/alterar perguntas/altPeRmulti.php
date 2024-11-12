<?php
$conn = new mysqli("localhost", "root", "", "3daw");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

function mostraPergunta($conn, $indice) {
    $sql = "SELECT id AS numero, pergunta, opcao_1 AS respostaA, opcao_2 AS respostaB, opcao_3 AS respostaC, opcao_4 AS respostaD, resposta_certa AS respostaCorreta FROM Perguntas WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $indice);
    $stmt->execute();
    $result = $stmt->get_result();
    $pergunta = $result->fetch_assoc();
    return $pergunta ? $pergunta : ["erro" => "Pergunta não encontrada"];
}

function salvarOuAtualizarPergunta($conn, $dados) {
    if ($dados['indice']) {
        $stmt = $conn->prepare(
            "UPDATE Perguntas SET pergunta = ?, opcao_1 = ?, opcao_2 = ?, opcao_3 = ?, opcao_4 = ?, resposta_certa = ? WHERE id = ?"
        );
        $stmt->bind_param("ssssssi", $dados['pergunta'], $dados['respostaA'], $dados['respostaB'], $dados['respostaC'], $dados['respostaD'], $dados['respostaCorreta'], $dados['indice']);
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO Perguntas (pergunta, opcao_1, opcao_2, opcao_3, opcao_4, resposta_certa) VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("ssssss", $dados['pergunta'], $dados['respostaA'], $dados['respostaB'], $dados['respostaC'], $dados['respostaD'], $dados['respostaCorreta']);
    }

    return $stmt->execute() ? ["sucesso" => true] : ["erro" => "Erro ao salvar ou atualizar a pergunta"];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    if ($data['acao'] === 'listar') {
        $indice = $data['indice'];
        echo json_encode(mostraPergunta($conn, $indice));
    } elseif ($data['acao'] === 'salvar') {
        echo json_encode(salvarOuAtualizarPergunta($conn, $data));
    } else {
        echo json_encode(["erro" => "Ação inválida"]);
    }
}

$conn->close();
