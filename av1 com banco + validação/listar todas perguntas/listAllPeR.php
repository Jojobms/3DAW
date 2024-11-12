<?php
$conn = new mysqli("localhost", "root", "", "3daw");

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$resultado = $conn->query("SELECT id, textoPergunta, textoEscolhaA, textoEscolhaB, textoEscolhaC, textoEscolhaD, opcaoCorreta FROM perguntas_multiplas_escolhas");

echo json_encode($resultado->fetch_all(MYSQLI_ASSOC));

$conn->close();
?>
