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

$mensagemAtualizacao = "";
$alunos = mostraAluno();

if (isset($_GET['indice'])) {
    $indice = $_GET['indice'];
    $aluno = $alunos[$indice];
} else {
    die("Aluno não encontrado.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $alunos = mostraAluno();
    $indice = $_POST['indice'];
    $alunos[$indice] = [$_POST['nome'], $_POST['cpf'], $_POST['dataNascimento'], $_POST['matricula']];
    saveAluno($alunos);
    echo "<script>alert('Aluno atualizado com sucesso!'); window.location.href = 'leTodosAlunos.php';</script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Editar Aluno</h1>

<section>
    <form method="POST">
        <input type="hidden" name="indice" value="<?php echo $indice; ?>">
        <label for="nome">Nome do Aluno:</label>
        <input type="text" name="nome" value="<?php echo $aluno[0]; ?>" required><br>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" value="<?php echo $aluno[1]; ?>" required><br>

        <label for="dataNascimento">Data de Nascimento:</label>
        <input type="date" name="dataNascimento" value="<?php echo $aluno[2]; ?>" required><br>

        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" value="<?php echo $aluno[3]; ?>" required><br>

        <input type="submit" value="Atualizar">
    </form>
</section>

<p><?php echo $mensagemAtualizacao; ?></p>

<a href="leTodosAlunos.php">Voltar à lista de alunos</a>

</body>
</html>
