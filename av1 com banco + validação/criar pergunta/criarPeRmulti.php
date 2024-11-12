<?php
$conexao = new mysqli("localhost", "root", "", "3daw");

if ($conexao->connect_error) {
    die("Falha na conexão: " . $conexao->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $numero = $_POST["numero"] ?? null;
    $pergunta = $_POST["pergunta"] ?? null;
    $respostas = [
        $_POST["respostaA"] ?? null,
        $_POST["respostaB"] ?? null,
        $_POST["respostaC"] ?? null,
        $_POST["respostaD"] ?? null
    ];
    $respostaCerta = $_POST["respostaCerta"] ?? null;

    if ($numero && $pergunta && !in_array(null, $respostas) && $respostaCerta) {
        $sql = "INSERT INTO perguntas_multiplas_escolhas (numero, textoPergunta, textoEscolhaA, textoEscolhaB, textoEscolhaC, textoEscolhaD, opcaoCorreta)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("issssss", $numero, $pergunta, ...$respostas, $respostaCerta);

        echo $stmt->execute() ? "Pergunta cadastrada com sucesso!" : "Erro ao cadastrar a pergunta.";
        $stmt->close();
    } else {
        echo "Erro: todos os campos devem ser preenchidos.";
    }
} else {
    echo "Erro: método não permitido.";
}

$conexao->close();
?>
