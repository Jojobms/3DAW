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

$disciplinas = mostraDisc();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Disciplinas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<h1>Disciplinas Cadastradas</h1>
<table border="1">
    <tr>
        <th>Nome</th>
        <th>Sigla</th>
        <th>Carga</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($disciplinas as $index => $disciplina): ?>
    <tr>
        <td><?php echo $disciplina[0]; ?></td>
        <td><?php echo $disciplina[1]; ?></td>
        <td><?php echo $disciplina[2]; ?></td>
        <td>
            <a href="attD.php?indice=<?php echo $index; ?>">Editar</a> |
            <a href="delD.php?indice=<?php echo $index; ?>" onclick="return confirm('Tem certeza que deseja excluir esta disciplina?');">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="index.php">Cadastrar nova disciplina</a>

</body>
</html>