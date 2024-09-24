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
$mensagemAtualizacao = "";
$perguntas = mostraPerguntas();

if (isset($_GET['indice'])) {
    $indice = $_GET['indice'];
    $pergunta = $perguntas[$indice];
} else {
    die("Aluno não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $perguntas = mostraPerguntas();
    $indice = $_POST['indice'];
    $perguntas[$indice] = [$_POST['numero'], $_POST['pergunta'], $_POST['respostaA'], $_POST['respostaB'], $_POST['respostaC'], $_POST['respostaD'], $_POST['respostaCerta']];
    savePergunta($perguntas);
    echo "<script>alert('Pergunta atualizada com sucesso!'); window.location.href = 'listAllPeR.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Pergunta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Editar Pergunta</h1>

<section>
    <form method="POST">
        <input type="hidden" name="indice" value="<?php echo $indice; ?>">
        <label for="numero">numero:</label>
        <input type="number" name="numero" value="<?php echo $pergunta[0]; ?>" required><br>

        <label for="pergunta">pergunta:</label>
        <input type="text" name="pergunta" value="<?php echo $pergunta[1]; ?>" required><br>

        <label for="respostaA">Opção A:</label>
        <input type="text" name="respostaA" value="<?php echo $pergunta[2]; ?>" required><br>

        <label for="respostaB">Opção B:</label>
        <input type="text" name="respostaB" value="<?php echo $pergunta[3]; ?>" required><br>

        <label for="respostaC">Opção C:</label>
        <input type="text" name="respostaC" value="<?php echo $pergunta[4]; ?>" required><br>

        <label for="respostaD">Opção D:</label>
        <input type="text" name="respostaD" value="<?php echo $pergunta[5]; ?>" required><br>

        <label for="respostaCerta">Resposta Correta:</label>
        <input type="text" name="respostaCorreta" value="<?php echo $pergunta[6]; ?>" required><br>

        <input type="submit" value="Atualizar">
    </form>
</section>

<p><?php echo $mensagemAtualizacao; ?></p>

<a href="listAllPeR.php">Voltar à lista de perguntas</a>

</body>
</html>
