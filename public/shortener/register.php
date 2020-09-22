<?php
    $error = null;

    $link = mysqli_connect(
        'localhost',
        getenv('MYSQL_USER'),
        getenv('MYSQL_PASSWORD'),
        'shortener'
    );

    if ($link == false){
        $error = 'Ошибка: Невозможно подключиться к MySQL '.mysqli_connect_error();
    }

    $username = $_POST["username"];
    $password = $_POST["password"];

    if($username !== null && $password !== null) {
        $result = mysqli_query($link, "
            SELECT * FROM Users WHERE Username = '".mysqli_real_escape_string($link, $username)."';
        ");

        if($result == false) {
            $error = 'Внутренняя ошибка сервера #1';
        } else if($result->num_rows > 0) {
            $error = 'Имя занято';
        } else {
            // имя не занято
            $insertResult = mysqli_query($link, "
                INSERT INTO
                    Users (Username, BcryptPassword)
                VALUES (
                    '".mysqli_real_escape_string($link, $username)."',
                    '".password_hash($password, PASSWORD_BCRYPT)."'
                );
            ");

            if ($insertResult == false) {
                $error = 'Внутренняя ошибка сервера #2';
            } else {
                // выдать токен

                $token = base64_encode( random_bytes(20) );

                $insertResult = mysqli_query($link, "
                    INSERT INTO
                        Tokens (Token, UserId)
                    VALUES (
                        '".$token."',
                        '".mysqli_insert_id($link)."'
                    );
                ");

                if ($insertResult == false) {
                    $error = 'Внутренняя ошибка сервера #3';
                } else {
                    setcookie('token', $token, time()+3600);
                    
                    $host = $_SERVER['HTTP_HOST'];
                    header("Location: http://$host/shortener");
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Регистрация</title>
    <link rel="stylesheet" href="/shortener/styles.css"/>
</head>
<body>
    <main>
        <h2>Регистрация</h2>
        <form action="/shortener/register.php" method="POST">
            <p>Имя пользователя</p>
            <p>
                <input required name="username" type="text" placeholder="username9999"/>
            </p>
            <p>Пароль</p>
            <p>
                <input required name="password" type="password" placeholder=""/>
            </p>
            <p>
                <input type="submit"/>
            </p>
        </form>
        <?php
            if($error) :
        ?>
            <p id="error"><?= $error ?></p>
        <?php
            endif;
        ?>
    </main>
</body>
</html>