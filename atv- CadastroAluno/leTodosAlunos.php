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

$alunos = mostraAluno();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Alunos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Alunos Cadastrados</h1>
<table border="1">
    <tr>
        <th>Nome</th>
        <th>CPF</th>
        <th>Data de Nascimento</th>
        <th>Matrícula</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($alunos as $index => $aluno): ?>
    <tr>
        <td><?php echo $aluno[0]; ?></td>
        <td><?php echo $aluno[1]; ?></td>
        <td><?php echo $aluno[2]; ?></td>
        <td><?php echo $aluno[3]; ?></td>
        <td>
            <a href="attAluno.php?indice=<?php echo $index; ?>">Editar</a> |
            <a href="delAluno.php?indice=<?php echo $index; ?>" onclick="return confirm('Tem certeza que deseja excluir este aluno?');">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="index.php">Cadastrar novo aluno</a>

</body>
</html>
