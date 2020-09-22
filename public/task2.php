<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Лабораторная работа №2</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
<main>
<?php
    $age = 14;

    // 1
    if (18 <= $age && $age <= 30) {
        echo 'Для молодежи', '<br/>';
    } else {
        echo 'Для всех возрастов', '<br/>';
    }

    // 2
    if (1 <= $age && $age <= 17) {
        echo 'Для детей', '<br/>';
    } else if (18 <= $age && $age <= 30) {
        echo 'Для молодежи', '<br/>';
    } else {
        echo 'Для всех возрастов', '<br/>';
    }

    // 3
    $counter = 1;

    while ($counter < 50) {
        echo $counter, ' ';
        $counter += 2;
    }
    echo '<br/>';

    for ($i=1; $i < 50; $i += 2) { 
        echo $i, ' ';
    }
?>
</main>
</body>
</html>