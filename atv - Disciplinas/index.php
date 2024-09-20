<?php

function addDisc($nome, $sigla, $carga) {
    $listaDisciplinas = mostraDisc();
    $listaDisciplinas[] = [$nome, $sigla, $carga];
    saveDisc($listaDisciplinas);
    return "Disciplina criada com sucesso!";
}

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

$mensagemCriacao = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"];
    $sigla = $_POST["sigla"];
    $carga = $_POST["carga"];
    $mensagemCriacao = addDisc($nome, $sigla, $carga);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Disciplina</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Cadastrar Nova Disciplina</h1>
<section>
    <form method="POST">
        <label for="nome">Nome da Disciplina:</label>
        <input type="text" name="nome" required><br>

        <label for="sigla">Sigla:</label>
        <input type="text" name="sigla" required><br>

        <label for="carga">Carga Semanal:</label>
        <input type="text" name="carga" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</section>
<p><?php echo $mensagemCriacao; ?></p>

<a href="lêD.php">Verificar lista de disciplinas</a>

<a href="lêUmD.php" style="padding-top: 10px">Buscar disciplina</a>

</body>
</html>