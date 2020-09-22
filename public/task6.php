<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Лабораторная работа №6</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
<main>
<form action="/task6.php" method="POST">
    <p>
        <b>Введите два числа и выберите операцию</b>
    </p>
    <p>
        <input required name="number1" type="number" placeholder="Первое число"/>
    </p>
    <p>
        <input required id="op1" type="radio" name="operation" value="add"/><label for="op1">(+) Сложить</label><br/>
        <input required id="op2" type="radio" name="operation" value="sub"/><label for="op2">(-) Вычесть</label><br/>
        <input required id="op3" type="radio" name="operation" value="mul"/><label for="op3">(*) Умножить</label><br/>
        <input required id="op4" type="radio" name="operation" value="div"/><label for="op4">(/) Разделить</label>
    </p>
    <p>
        <input required name="number2" type="number" placeholder="Второе число"/>
    </p>
    <p>
        <input type="submit"/>
    </p>
</form>
<?php
    $number1   = $_POST["number1"];
    $number2   = $_POST["number2"];
    $operation = $_POST["operation"];

    $result = 'неизвестная операция';

    switch ($operation) {
        case 'add':
            $result = "$number1 + $number2 = ".($number1 + $number2);
            break;
        
        case 'sub':
            $result = "$number1 - $number2 = ".($number1 - $number2);
            break;

        case 'mul':
            $result = "$number1 * $number2 = ".($number1 * $number2);
            break;

        case 'div':
            $result = "$number1 / $number2 = ".($number1 / $number2);
            break;
    }

    if($number1 !== null && $number2 !== null) : ?>
        <p>
            <b>Результат <?php echo $result ?> </b>
        </p>
    <?php
    endif;
    ?>
</main>
</body>
</html>