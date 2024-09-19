<?php

function carregarDisciplinas() {
    $listaDisciplinas = [];
    if (file_exists("disciplinas.txt")) {
        $arquivo = fopen("disciplinas.txt", "r") or die("Erro ao abrir arquivo");
        while (($linha = fgets($arquivo)) !== false) {
            $linha = trim($linha);
            if ($linha != "" && $linha != "nome;sigla;carga") {
                $listaDisciplinas[] = explode(";", $linha);
            }
        }
        fclose($arquivo);
    }
    return $listaDisciplinas;
}
function buscarDisciplinaPorSigla($sigla) {
    $listaDisciplinas = carregarDisciplinas();
    foreach ($listaDisciplinas as $disciplina) {
        if (strcasecmp($disciplina[1], $sigla) == 0) {
            return $disciplina;
        }
    }
    return null;
}

$mensagemBusca = "";
$disciplina = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sigla = $_POST['sigla'];
    $disciplina = buscarDisciplinaPorSigla($sigla);
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
