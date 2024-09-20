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

function saveDisc($listaDisciplinas) {
    $dados = "nome;sigla;carga\n";
    $dados .= implode("\n", array_map(function($disciplina) {
        return implode(";", $disciplina);
    }, $listaDisciplinas)) . "\n";
    file_put_contents("disciplinas.txt", $dados) or die("Erro ao abrir arquivo");
}

function attDisc($indice, $nome, $sigla, $carga) {
    $listaDisciplinas = mostraDisc();
    if (!isset($listaDisciplinas[$indice])) {
        return "Disciplina não encontrada!";
    }
    $listaDisciplinas[$indice] = [$nome, $sigla, $carga];
    saveDisc($listaDisciplinas);
    return "Disciplina atualizada com sucesso!";
}


$mensagemAtualizacao = "";
$disciplinas = mostraDisc();


if (isset($_GET['indice'])) {
    $indice = $_GET['indice'];
    $disciplina = $disciplinas[$indice];
} else {
    die("Disciplina não encontrada.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $disciplinas = mostraDisc();
    $indice = $_POST['indice'];
    $disciplinas[$indice] = [$_POST['nome'], $_POST['sigla'], $_POST['carga']];
    saveDisc($disciplinas);
    echo "<script>alert('Disciplina atualizada com sucesso!'); window.location.href = 'lêD.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Disciplina</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Editar Disciplina</h1>

<section>
    <form method="POST">
        <input type="hidden" name="indice" value="<?php echo $indice; ?>">
        <label for="nome">Nome da Disciplina:</label>
        <input type="text" name="nome" value="<?php echo $disciplina[0]; ?>" required><br>

        <label for="sigla">Sigla:</label>
        <input type="text" name="sigla" value="<?php echo $disciplina[1]; ?>" required><br>

        <label for="carga">Carga Semanal:</label>
        <input type="text" name="carga" value="<?php echo $disciplina[2]; ?>" required><br>

        <input type="submit" value="Atualizar">
    </form>
</section>

<p><?php echo $mensagemAtualizacao; ?></p>

<a href="lêD.php">Voltar à lista de disciplinas</a>

</body>
</html>