<?php
header('Content-Type: application/json');

$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "bancojurema";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["erro" => "Falha na conexão: " . $conn->connect_error]));
}


if (!isset($_POST['id_agendamento'])) {
    echo json_encode(["erro" => "ID do agendamento não fornecido."]);
    exit;
}

$id_agendamento = intval($_POST['id_agendamento']);

$sql = "DELETE FROM agendamento WHERE id_agendamento = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_agendamento);

if ($stmt->execute()) {
    echo json_encode(["sucesso" => "Agendamento removido com sucesso."]);
} else {
    echo json_encode(["erro" => "Erro ao remover o agendamento: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
