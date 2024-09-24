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

$perguntas = mostraPerguntas();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Perguntas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Perguntas Adicionadas</h1>
<table border="1">
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
    <?php foreach ($perguntas as $index => $pergunta): ?>
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
    <?php endforeach; ?>
</table>

<a href="criarPeRmulti.php">Adicionar nova pergunta</a>

</body>
</html>