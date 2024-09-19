<?php

function adicionarDisciplina($nome, $sigla, $carga) {
    $listaDisciplinas = carregarDisciplinas();
    $listaDisciplinas[] = [$nome, $sigla, $carga];
    salvarDisciplinas($listaDisciplinas);
    return "Disciplina criada com sucesso!";
}

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

$mensagemCriacao = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"];
    $sigla = $_POST["sigla"];
    $carga = $_POST["carga"];
    $mensagemCriacao = adicionarDisciplina($nome, $sigla, $carga);
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
