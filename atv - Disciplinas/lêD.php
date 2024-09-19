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


$disciplinas = carregarDisciplinas();
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
            <!-- Link para editar a disciplina -->
            <a href="attD.php?indice=<?php echo $index; ?>">Editar</a> |
            <!-- Link para excluir a disciplina -->
            <a href="delD.php?indice=<?php echo $index; ?>" onclick="return confirm('Tem certeza que deseja excluir esta disciplina?');">Excluir</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<a href="index.php">Cadastrar nova disciplina</a>

</body>
</html>
