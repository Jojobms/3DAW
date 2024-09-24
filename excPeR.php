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

function excPergunta($indice) {
    $perguntas = mostraPerguntas();
    if (!isset($perguntas[$indice])) return "Pergunta não encontrada!";
    
    unset($perguntas[$indice]);
    savePergunta(array_values($perguntas));
    
    return "Pergunta excluída com sucesso!";
}

$mensagemExclusao = "";
if (isset($_GET['indice'])) {
    $indice = $_GET['indice'];
    $mensagemExclusao = excPergunta($indice);
} else {
    die("Pergunta não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Pergunta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Excluir Pergunta</h1>

<p><?php echo $mensagemExclusao; ?></p>

<a href="listAllPeR.php">Voltar à lista de perguntas</a>

</body>
</html>
