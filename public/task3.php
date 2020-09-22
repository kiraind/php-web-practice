<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Лабораторная работа №3</title>
    <link rel="stylesheet" href="styles.css"/>
</head>
<body>
<main>
<?php
    // 1
    $sample = [ 4, 3, 6, 2, 7, 6, 8, 1, 4, 6, 9 ];

    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';

    echo 'count($sample): ', count($sample), '<br />';
    echo 'sizeof($sample): ', sizeof($sample), '<br />';
    echo 'array_count_values($sample): ',
        json_encode(array_count_values($sample)), '<br />';
    echo '<br />';

    echo 'array_shift($sample): ', json_encode( array_shift($sample) ), '<br />';
    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';

    echo 'array_pop($sample): ', json_encode( array_pop($sample) ), '<br />';
    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';

    echo 'array_push($sample, 9): ', json_encode( array_push($sample, 9) ), '<br />';
    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';

    echo 'array_unshift($sample, 4): ', json_encode( array_unshift($sample, 4) ), '<br />';
    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';

    echo 'array_slice($sample, 0, 5): ', json_encode( array_slice($sample, 0, 5) ), '<br />';
    echo '<br />';

    echo 'in_array($sample, 9): ', json_encode( in_array(9, $sample) ), '<br />';
    echo '<br />';

    echo 'array_search(3, $sample): ', json_encode( array_search(3, $sample) ), '<br />';
    echo '<br />';

    echo 'sort($sample): ', json_encode( sort($sample) ), '<br />';
    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';

    echo 'rsort($sample): ', json_encode( rsort($sample) ), '<br />';
    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';
    
    
    echo 'asort($sample): ', json_encode( asort($sample) ), '<br />';
    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';

    echo 'arsort($sample): ', json_encode( arsort($sample) ), '<br />';
    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';
    
    echo 'krsort($sample): ', json_encode( krsort($sample) ), '<br />';
    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';

    echo 'ksort($sample): ', json_encode( ksort($sample) ), '<br />';
    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';
    
    echo 'array_merge([1, 3, 5, 7], [2, 4, 6, 8]): ',
        json_encode( array_merge([1, 3, 5, 7], [2, 4, 6, 8]) ), '<br />';
    

    // 2
    $movies = [
        "Комедия" => [ "Кролик Джоджо", "Большой Лебовски", "Отель «Гранд Будапешт»" ],
        "Научная фантастика" => [ "Бегущий по лезвию", "Солярис", "Космическая одиссея 2001 года" ],
        "Триллер" => [ "Дом, который построил Джек", "Платформа", "Сияние" ],
    ];

    // 3
    echo '<ol>Фильмы:';
    foreach ($movies as $genre => $titles) {
        echo "<li>$genre:<ol>";

        foreach($titles as $title) {
            echo "<li>$title</li>";
        }

        echo '</ol></li>';
    }
    echo '</ol>';
?>
</main>
</body>
</html>