<?php
function mostraAluno() {
    if (!file_exists("alunos.txt")) {
        return [];
    }
    return array_map(function($linha) {
        return explode(";", trim($linha));
    }, array_filter(file("alunos.txt"), function($linha) {
        return trim($linha) && strpos($linha, 'nome;cpf;dataNascimento;matricula') === false;
    }));
}

function saveAluno($listaAlunos) {
    $dados = "nome;cpf;dataNascimento;matricula\n";
    $dados .= implode("\n", array_map(function($aluno) {
        return implode(";", $aluno);
    }, $listaAlunos)) . "\n";
    file_put_contents("alunos.txt", $dados) or die("Erro ao abrir arquivo");
}

function apgAluno($indice) {
    $alunos = mostraAluno();
    if (!isset($alunos[$indice])) return "Aluno não encontrado!";
    
    unset($alunos[$indice]);
    saveAluno(array_values($alunos));
    
    return "Aluno excluído com sucesso!";
}

$mensagemExclusao = "";
if (isset($_GET['indice'])) {
    $indice = $_GET['indice'];
    $mensagemExclusao = apgAluno($indice);
} else {
    die("Aluno não encontrado.");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Excluir Aluno</h1>

<p><?php echo $mensagemExclusao; ?></p>

<a href="leTodosAlunos.php">Voltar à lista de alunos</a>

</body>
</html>
