<?php

$n1;
$n2;
$result = "???";
$calcular;


if(isset($_GET['n1'], $_GET['n2'], $_GET['Operação'])){
    $n1 = $_GET['n1'];
    $n2 = $_GET['n2'];
    $calcular = $_GET['Operação'];

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
            $result = $n1 / $n2;
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
            height: 256px;
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
            <label for="num2">Número 2:</label>
            <input type="text" name="n2" id="num2">
            <select name="Operação" id="op">
                <option value="Soma">Soma</option>
                <option value="Subt">Subtração</option>
                <option value="Multi">Multiplicação</option>
                <option value="Div">Divisão</option>
            </select>
            <input type="submit" value="Calcular">
            <p>O resultado é: <?= $result ?></p>
        </form>
    </section>
</body>
</html>
