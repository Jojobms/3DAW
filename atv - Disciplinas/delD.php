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


function apgDisc($indice) {
    $disciplinas = mostraDisc();
    if (!isset($disciplinas[$indice])) return "Disciplina não encontrada!";
    
    unset($disciplinas[$indice]);
    saveDisc(array_values($disciplinas));
    
    return "Disciplina excluída com sucesso!";
}


$mensagemExclusao = "";
if (isset($_GET['indice'])) {
    $indice = $_GET['indice'];
    $mensagemExclusao = apgDisc($indice);
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