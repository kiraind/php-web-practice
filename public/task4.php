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
    function my_array_slice(array $arr = [], int $offset = 0, int $count = 0)
    {
        $slice = [];

        for($i = 0, $j = $offset; $i < $count; $i += 1, $j += 1) {
            if($arr[$j] !== null) {
                $slice[$i] = $arr[$j];
            }
        }

        return $slice;
    }

    // 1
    $sample = [ 0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10 ];

    echo '$sample: ', json_encode( $sample ), '<br />';
    echo '<br />';

    echo 'array_slice($sample, 0, 5): ', json_encode( array_slice($sample, 0, 5) ), '<br />';
    echo 'my_array_slice($sample, 0, 5): ', json_encode( my_array_slice($sample, 0, 5) ), '<br />';
    echo '<br />';

    echo 'array_slice($sample, 3, 4): ', json_encode( array_slice($sample, 3, 4) ), '<br />';
    echo 'my_array_slice($sample, 3, 4): ', json_encode( my_array_slice($sample, 3, 4) ), '<br />';
    echo '<br />';

    echo 'array_slice($sample, 10, 5): ', json_encode( array_slice($sample, 10, 5) ), '<br />';
    echo 'my_array_slice($sample, 10, 5): ', json_encode( my_array_slice($sample, 10, 5) ), '<br />';
    echo '<br />';
?>
</main>
</body>
</html>