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

function salvarDisciplinas($listaDisciplinas) {
    $arquivo = fopen("disciplinas.txt", "w") or die("Erro ao abrir arquivo");
    fwrite($arquivo, "nome;sigla;carga\n");
    foreach ($listaDisciplinas as $disciplina) {
        fwrite($arquivo, implode(";", $disciplina) . "\n");
    }
    fclose($arquivo);
}

function atualizarDisciplina($indice, $nome, $sigla, $carga) {
    $listaDisciplinas = carregarDisciplinas();
    if (isset($listaDisciplinas[$indice])) {
        $listaDisciplinas[$indice] = [$nome, $sigla, $carga];
        salvarDisciplinas($listaDisciplinas);
        return "Disciplina atualizada com sucesso!";
    }
    return "Disciplina não encontrada!";
}


$mensagemAtualizacao = "";
$disciplinas = carregarDisciplinas();

if (isset($_GET['indice'])) {
    $indice = $_GET['indice'];
    $disciplina = $disciplinas[$indice];
} else {
    die("Disciplina não encontrada.");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $indice = $_POST["indice"];
    $nome = $_POST["nome"];
    $sigla = $_POST["sigla"];
    $carga = $_POST["carga"];
    $mensagemAtualizacao = atualizarDisciplina($indice, $nome, $sigla, $carga);
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
