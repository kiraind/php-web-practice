<?php
    $error    = null;
    $user     = null;
    $currLink = null;

    $link = mysqli_connect(
        'localhost',
        getenv('MYSQL_USER'),
        getenv('MYSQL_PASSWORD'),
        'shortener'
    );

    if ($link == false) {
        $error = 'Ошибка: Невозможно подключиться к MySQL '.mysqli_connect_error();
    }

    if($_COOKIE['token'] != null) {
        $newlink = $_POST["link"];

        $result = mysqli_query($link, "
            SELECT
                Id,
                Username
            FROM
                Users
                INNER JOIN
                Tokens
                    ON Users.Id = Tokens.UserId
            WHERE Tokens.Token = '".mysqli_real_escape_string($link, $_COOKIE['token'])."';
        ");

        if($result == false) {
            $error = 'Внутренняя ошибка сервера #1';
        } else if($result->num_rows == 1) {
            $row = mysqli_fetch_array($result);
            $user = [
                "id" => $row['Id'],
                "username" => $row['Username'],
            ];

            $result = mysqli_query($link, "
                SELECT
                    Link,
                    Shortened,
                    Clicks,
                    Created
                FROM
                    Links
                    INNER JOIN
                    Users
                        ON Links.UserId = Users.Id
                WHERE
                    Users.Id = ".$user['id']." AND
                    Links.Shortened = '".mysqli_real_escape_string($link, $_GET['s'])."'
                ORDER BY Created DESC;
            ");
            if($result == false) {
                $error = 'Внутренняя ошибка сервера #3';
            } else {
                $row = mysqli_fetch_array($result);

                if($row !== null) {
                    $currLink = [
                        'link' => $row['Link'],
                        'shortened' => $row['Shortened'],
                        'clicks' => $row['Clicks'],
                        'created' => $row['Created'],
                    ];
                } else {
                    $error = 'Нет прав для просмотра этой ссылки';
                }
            }
        }
    } else {
        $error = 'Нет прав для просмотра этой ссылки';
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Сокращатель ссылок</title>
    <link rel="stylesheet" href="/shortener/styles.css"/>
</head>
<body>
    <header>
        <div id="headerbody">
            <div>Сокращатель ссылок</div>

            <?php if($user !== null) : ?>
            <div>
                <?= $user['username'] ?>
                <button onclick="window.location = '/shortener/logout.php'">Выйти</button>
            </div>
            <?php else : ?>
            <div>
                <button onclick="window.location = '/shortener/register.php'">Зарегистрироваться</button>
                <button onclick="window.location = '/shortener/login.php'">Войти</button>
            </div>
            <?php endif ?>
        </div>
    </header>
    <main>
        <?php if($user !== null) : ?>
            <div class="link">
                <div class="linkshort">
                    <span>sho.rt/?s=<?= $currLink['shortened'] ?></span> — переходов: <?= $currLink['clicks'] ?></div>
                <div class="linkorig">
                    <?= $currLink['created'] ?>
                    &middot;
                    <a target="_blank" rel="noopener noreferrer" href="<?= $currLink['link'] ?>">
                        <?= $currLink['link'] /* без xss-защиты, т. к. не публичный контент */ ?>
                    </a>
                </div>
            </div>
        <?php endif ?>

        <?php if($error) : ?>
            <p id="error"><?= $error ?></p>
        <?php endif ?>
    </main>
</body>
</html>