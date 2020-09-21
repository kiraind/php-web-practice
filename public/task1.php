<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Лабораторная работа №1</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
<main>
<?php
    // 1
    $someInteger = 42;
    $someFloat   = 3.14;
    $someString  = 'Hello, World!';
    $someBoolean = false;
    $someArray   = [ 1, 2, 3, 4, 5 ];

    echo '$someInteger: ', gettype($someInteger),  '<br/>';
    echo '$someFloat: ',   gettype($someFloat),    '<br/>';
    echo '$someString: ',  gettype($someString),   '<br/>';
    echo '$someBoolean: ', gettype($someBoolean),  '<br/>';
    echo '$someArray: ',   gettype($someArray),    '<br/>';

    // 2
    $a = 100;
    $b = 120;

    echo '$a: ', $a, '<br/>';
    echo '$b: ', $b, '<br/>';

    echo '$a = $b -> ', $a == $b ? 'yes' : 'no', '<br/>';
    echo '$a < $b -> ', $a <  $b ? 'yes' : 'no', '<br/>';
    echo '$a ≤ $b -> ', $a <= $b ? 'yes' : 'no', '<br/>';
    echo '$a > $b -> ', $a >  $b ? 'yes' : 'no', '<br/>';
?>
</main>
</body>
</html>