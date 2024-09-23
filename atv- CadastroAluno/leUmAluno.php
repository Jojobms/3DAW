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

function buscaAluno($matricula) {
    foreach (mostraAluno() as $aluno) {
        if (!strcasecmp($aluno[3], $matricula)) return $aluno;
    }
    return null;
}

$mensagemBusca = "";
$aluno = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = $_POST['matricula'];
    $aluno = buscaAluno($matricula);
    if ($aluno) {
        $mensagemBusca = "Aluno encontrado!";
    } else {
        $mensagemBusca = "Aluno não encontrado.";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Aluno</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Buscar Aluno por Matrícula</h1>

<section>
    <form method="POST">
        <label for="matricula">Matrícula:</label>
        <input type="text" name="matricula" required>
        <input type="submit" value="Buscar">
    </form>

    <p><?php echo $mensagemBusca; ?></p>

    <?php if ($aluno): ?>
    <table>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Matrícula</th>
        </tr>
        <tr>
            <td><?php echo $aluno[0]; ?></td>
            <td><?php echo $aluno[1]; ?></td>
            <td><?php echo $aluno[2]; ?></td>
            <td><?php echo $aluno[3]; ?></td>
        </tr>
    </table>
    <?php endif; ?>
</section>

<a href="leTodosAlunos.php">Voltar à lista de alunos</a>

</body>
</html>
