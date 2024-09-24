<?php

function criaPerg($numero, $pergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCerta) {
    $listaPerguntas = mostraPerguntas(); 
    $listaPerguntas[] = [$numero, $pergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCerta];
    savePergunta($listaPerguntas);
    return "Pergunta adicionada com sucesso!";
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
    file_put_contents("pergeresp.txt", $dados) or die("Erro ao abrir arquivo");
}

$mensagemCriacao = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero = $_POST["numero"];
    $pergunta = $_POST["pergunta"];
    $respostaA = $_POST["respostaA"];
    $respostaB = $_POST["respostaB"];
    $respostaC = $_POST["respostaC"];
    $respostaD = $_POST["respostaD"];
    $respostaCerta = $_POST["respostaCerta"];
    $mensagemCriacao = criaPerg($numero, $pergunta, $respostaA, $respostaB, $respostaC, $respostaD, $respostaCerta);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Pergunta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Criar nova pergunta</h1>
<section>
    <form method="POST">
        <label for="numero">Número da pergunta:</label>
        <input type="number" name="numero" id="numero" required><br>

        <label for="pergunta">Pergunta:</label>
        <input type="text" name="pergunta" id="pergunta" required><br>

        <label for="respostaA">Resposta letra A:</label>
        <input type="text" name="respostaA" id="respostaA" required><br>
        
        <label for="respostaB">Resposta letra B:</label>
        <input type="text" name="respostaB" id="respostaB" required><br>

        <label for="respostaC">Resposta letra C:</label>
        <input type="text" name="respostaC" id="respostaC" required><br>

        <label for="respostaD">Resposta letra D:</label>
        <input type="text" name="respostaD" id="respostaD" required><br>

        <label for="respostaCerta">Resposta Certa:</label>
        <input type="text" name="respostaCerta" id="respostaCerta" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</section>
<p><?php echo $mensagemCriacao; ?></p>

<a href="listAllPeR.php">Verificar lista de perguntas</a>
<a href="listOnPerg.php" style="padding-top: 10px">Buscar pergunta</a>

</body>
</html>

