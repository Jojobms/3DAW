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
    foreach (mostraPerguntas() as $pergunta) {
        if (!strcasecmp($pergunta[0], $numero)) return $pergunta;
    }
    return null;
}

$mensagemBusca = "";
$pergunta = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero = $_POST['numero'];
    $pergunta = buscaPergunta($numero);
    if ($pergunta) {
        $mensagemBusca = "Pergunta encontrada!";
    } else {
        $mensagemBusca = "Pergunta não encontrada.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Pergunta</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Buscar Pergunta por Número</h1>

<section>
    <form method="POST">
        <label for="numero">Número:</label>
        <input type="number" name="numero" id="numero" required>
        <input type="submit" value="Buscar">
    </form>

    <p><?php echo $mensagemBusca; ?></p>

    <?php if ($pergunta): ?>
    <table>
        <tr>
        <th>Numero</th>
        <th>Pergunta</th>
        <th>Opção A</th>
        <th>Opção B</th>
        <th>Opção C</th>
        <th>Opção D</th>
        <th>Resposta Correta</th>
        <th>Ações</th>
        </tr>
        <tr>
        <td><?php echo $pergunta[0]; ?></td>
        <td><?php echo $pergunta[1]; ?></td>
        <td><?php echo $pergunta[2]; ?></td>
        <td><?php echo $pergunta[3]; ?></td>
        <td><?php echo $pergunta[4]; ?></td>
        <td><?php echo $pergunta[5]; ?></td>
        <td><?php echo $pergunta[6]; ?></td>
        <td>
            <a href="altPeRmulti.php?indice=<?php echo $index; ?>">Editar</a> |
            <a href="excPeR.php?indice=<?php echo $index; ?>" onclick="return confirm('Tem certeza que deseja excluir este pergunta?');">Excluir</a>
        </td>
        </tr>
    </table>
    <?php endif; ?>
</section>

<a href="listAllPeR.php">Voltar à lista de perguntas</a>

</body>
</html>
