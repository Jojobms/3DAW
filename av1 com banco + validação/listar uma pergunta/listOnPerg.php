<?php
$conn = new mysqli("localhost", "root", "", "3daw");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

function buscaPergunta($numero) {
    global $conn;
    $stmt = $conn->prepare("SELECT id, textoPergunta, textoEscolhaA, textoEscolhaB, textoEscolhaC, textoEscolhaD, opcaoCorreta FROM perguntas_multiplas_escolhas WHERE id = ?");
    $stmt->bind_param("i", $numero);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $pergunta = $resultado->num_rows > 0 ? $resultado->fetch_assoc() : null;
    $stmt->close();
    
    return $pergunta;
}

header('Content-Type: application/json');

$numero = isset($_GET['numero']) ? $_GET['numero'] : null;
$resultado = buscaPergunta($numero);

if ($resultado) {
    echo json_encode([
        'pergunta' => $resultado
    ]);
} else {
    echo json_encode(['pergunta' => null]);
}

$conn->close();
?>
