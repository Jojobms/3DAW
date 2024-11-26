<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bancojurema";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['message' => 'Falha na conexão com o banco de dados: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true); 

function cadastrarFuncionario($nome, $cargo, $carga_horaria, $tempo_servico, $precoservico, $conn) {
    $sql = "INSERT INTO funcionario (nome, cargo, carga_horaria, tempo_servico, precoservico) 
            VALUES ('$nome', '$cargo', '$carga_horaria', '$tempo_servico', '$precoservico')";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Funcionário cadastrado com sucesso!']);
    } else {
        echo json_encode(['message' => 'Erro ao cadastrar funcionário: ' . $conn->error]);
    }
}

function editarFuncionario($id_funcionario, $nome, $cargo, $carga_horaria, $tempo_servico, $precoservico, $conn) {
    $sql = "UPDATE funcionario SET nome='$nome', cargo='$cargo', carga_horaria='$carga_horaria', 
            tempo_servico='$tempo_servico', precoservico='$precoservico' WHERE id_funcionario='$id_funcionario'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Funcionário atualizado com sucesso!']);
    } else {
        echo json_encode(['message' => 'Erro ao atualizar funcionário: ' . $conn->error]);
    }
}

function excluirFuncionario($id_funcionario, $conn) {
    $sql = "DELETE FROM funcionario WHERE id_funcionario='$id_funcionario'";
    if ($conn->query($sql) === TRUE) {
        echo json_encode(['message' => 'Funcionário excluído com sucesso!']);
    } else {
        echo json_encode(['message' => 'Erro ao excluir funcionário: ' . $conn->error]);
    }
}

function listarFuncionarios($conn) {
    $sql = "SELECT * FROM funcionario";
    $result = $conn->query($sql);
    $funcionarios = [];
    while ($row = $result->fetch_assoc()) {
        $funcionarios[] = $row;
    }
    echo json_encode($funcionarios);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cadastrarFuncionario($data['nome'], $data['cargo'], $data['carga_horaria'], $data['tempo_servico'], $data['precoservico'], $conn);
} elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    editarFuncionario($data['id_funcionario'], $data['nome'], $data['cargo'], $data['carga_horaria'], $data['tempo_servico'], $data['precoservico'], $conn);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    excluirFuncionario($data['id_funcionario'], $conn);
} else {
    listarFuncionarios($conn);
}

$conn->close();
?>
