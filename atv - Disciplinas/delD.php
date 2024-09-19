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

function excluirDisciplina($indice) {
    $listaDisciplinas = carregarDisciplinas();
    if (isset($listaDisciplinas[$indice])) {
        unset($listaDisciplinas[$indice]);
        salvarDisciplinas(array_values($listaDisciplinas)); 
        return "Disciplina excluída com sucesso!";
    }
    return "Disciplina não encontrada!";
}

$mensagemExclusao = "";
if (isset($_GET['indice'])) {
    $indice = $_GET['indice'];
    $mensagemExclusao = excluirDisciplina($indice);
} else {
    die("Disciplina não encontrada.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Disciplina</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Excluir Disciplina</h1>

<p><?php echo $mensagemExclusao; ?></p>

<a href="lêD.php">Voltar à lista de disciplinas</a>

</body>
</html>
