<?php

$n1 = 0;
$n2 = 0;
$result = "???";
$calcular;


if(isset($_GET['n1'], $_GET['n2'], $_GET['Operacao'])){
    $n1 = $_GET['n1'];
    $n2 = $_GET['n2'];
    $calcular = $_GET['Operacao'];

    switch($calcular){
        case 'Soma':
            $result = $n1 + $n2;
            break;
        case 'Subt':
            $result = $n1 - $n2;
            break;
        case 'Multi':
            $result = $n1 * $n2;
            break;
        case 'Div':
            if ($n2 != 0) {
                $result = $n1 / $n2;
            } else {
                $result = "Erro: Divisão por zero";
            }
            break;
        case 'Raiz':
            if ($n1 >= 0) {
                $result = sqrt($n1);
            } else {
                $result = "Erro: Raiz de número negativo";
            }
            break;
        case 'Potencia':
            $result = pow($n1, $n2);
            break;
        case 'InversaoNumero':
            if ($n1 != 0) {
                $result = 1 / $n1;
            } else {
                $result = "Erro: Inversão de zero";
            }
            break;
        case 'InversaoSinal':
            $result = -$n1;
            break;
        case 'Seno':
            $result = sin(deg2rad($n1)); // Converte graus para radianos
            break;
        case 'Cosseno':
            $result = cos(deg2rad($n1)); // Converte graus para radianos
            break;
        case 'Tangente':
            $result = tan(deg2rad($n1)); // Converte graus para radianos
            break;
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; 
            margin: 0; 
            background-color: gray;
        }

        p, label, input, select {
            display: block;
            color: cyan;
            margin: 10px;
        }

        input {
            color: black;
        }

        section {
            background-color: black;
            width: 256px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 10px 20px 20px 10px cyan;
            border-radius: 30px;
        }
    </style>
</head>
<body>
    <section>
        <form>
            <label for="num1">Número 1:</label>
            <input type="text" name="n1" id="num1">
            <label for="num2">Número 2 (para operações binárias):</label>
            <input type="text" name="n2" id="num2">
            <select name="Operacao" id="op">
                <option value="Soma">Soma</option>
                <option value="Subt">Subtração</option>
                <option value="Multi">Multiplicação</option>
                <option value="Div">Divisão</option>
                <option value="Raiz">Raiz Quadrada</option>
                <option value="Potencia">Potência</option>
                <option value="InversaoNumero">Inversão de Número</option>
                <option value="InversaoSinal">Inversão de Sinal</option>
                <option value="Seno">Seno</option>
                <option value="Cosseno">Cosseno</option>
                <option value="Tangente">Tangente</option>
            </select>
            <input type="submit" value="Calcular">
            <p>O resultado é: <?= $result ?></p>
        </form>
    </section>
</body>
</html>
