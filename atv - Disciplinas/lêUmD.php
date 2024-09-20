<?php

function mostraDisc() {
    if (!file_exists("disciplinas.txt")) {
        return [];
    }
    return array_map(function($linha) {
        return explode(";", trim($linha));
    }, array_filter(file("disciplinas.txt"), function($linha) {
        return trim($linha) && strpos($linha, 'nome;sigla;carga') === false;
    }));
}

function caçaDisc($sigla) {
    foreach (mostraDisc() as $disciplina) {
        if (!strcasecmp($disciplina[1], $sigla)) return $disciplina;
    }
    return null;
}


$mensagemBusca = "";
$disciplina = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sigla = $_POST['sigla'];
    $disciplina = caçaDisc($sigla);
    if ($disciplina) {
        $mensagemBusca = "Disciplina encontrada!";
    } else {
        $mensagemBusca = "Disciplina não encontrada.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Disciplina</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Buscar Disciplina por Sigla</h1>

<section>
    <form method="POST">
        <label for="sigla">Sigla:</label>
        <input type="text" name="sigla" required>
        <input type="submit" value="Buscar">
    </form>

    <p><?php echo $mensagemBusca; ?></p>

    <?php if ($disciplina): ?>
    <table>
        <tr>
            <th>Nome</th>
            <th>Sigla</th>
            <th>Carga Semanal</th>
        </tr>
        <tr>
            <td><?php echo $disciplina[0]; ?></td>
            <td><?php echo $disciplina[1]; ?></td>
            <td><?php echo $disciplina[2]; ?></td>
        </tr>
    </table>
    <?php endif; ?>
</section>

<a href="lêD.php">Voltar à lista de disciplinas</a>

</body>
</html>