<?php

function addAluno($nome, $cpf, $dataNascimento, $matricula) {
    $cpf = formataCPF($cpf);
    $listaAlunos = mostraAluno();
    $listaAlunos[] = [$nome, $cpf, $dataNascimento, $matricula];
    saveAluno($listaAlunos);
    return "Aluno cadastrado com sucesso!";
}

function formataCPF($cpf) {
    $cpf = preg_replace('/\D/', '', $cpf);
    return preg_replace('/(\d{3})(\d{3})(\d{3})(\d{2})/', '$1.$2.$3-$4', $cpf);
}

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

$mensagemCriacao = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST["nome"];
    $cpf = $_POST["cpf"];
    $dataNascimento = $_POST["dataNascimento"];
    $matricula = $_POST["matricula"];
    $mensagemCriacao = addAluno($nome, $cpf, $dataNascimento, $matricula);
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Cadastrar Novo Aluno</h1>
<section>
    <form method="POST">
        <label for="nome">Nome do Aluno:</label>
        <input type="text" name="nome" required><br>

        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" maxlength="14" required><br>

        <label for="dataNascimento">Data de Nascimento:</label>
        <input type="date" name="dataNascimento" required><br>

        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" required><br>

        <input type="submit" value="Cadastrar">
    </form>
</section>
<p><?php echo $mensagemCriacao; ?></p>

<a href="leTodosAlunos.php">Verificar lista de alunos</a>
<a href="leUmAluno.php" style="padding-top: 10px">Buscar aluno</a>

</body>
</html>
