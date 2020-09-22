<?php
    $error = null;
    $user  = null;

    $link = mysqli_connect(
        'localhost',
        getenv('MYSQL_USER'),
        getenv('MYSQL_PASSWORD'),
        'shortener'
    );

    if ($link == false) {
        $error = 'Ошибка: Невозможно подключиться к MySQL '.mysqli_connect_error();
    }

    if($_GET['s'] !== null) {
        $result = mysqli_query($link, "
            SELECT
                Link
            FROM
                Links
            WHERE
                Links.Shortened = '".mysqli_real_escape_string($link, $_GET['s'])."';
        ");
        if($result == false) {
            $error = 'Внутренняя ошибка сервера #4';
        } else {
            $row = mysqli_fetch_array($result);

            if($row !== null) {
                $currLink = $row['Link'];

                // обновить счетчик
                $updateResult = mysqli_query($link, "
                    UPDATE Links SET Clicks = Clicks + 1 WHERE Links.Shortened = '".$_GET['s']."';
                ");

                if ($updateResult == false) {
                    $error = 'Внутренняя ошибка сервера #5';
                }

                header("Location: $currLink");
            } else {
                // ссылка не найдена
                $host = $_SERVER['HTTP_HOST'];
                header("Location: http://$host/shortener");
            }
        }
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

            if($newlink !== null) {
                $insertResult = mysqli_query($link, "
                    INSERT INTO Links (
                        UserId,
                        Link,
                        Shortened
                    )
                    VALUES (
                        ".$user['id'].",
                        '".mysqli_real_escape_string($link, $newlink)."',
                        '".substr(
                            base64_encode( random_bytes(20) ),
                            0,
                            7
                        )."'
                    );
                ");
    
                if ($insertResult == false) {
                    $error = 'Внутренняя ошибка сервера #2';
                }
            }

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
                WHERE Users.Id = ".$user['id']."
                ORDER BY Created DESC;
            ");
            if($result == false) {
                $error = 'Внутренняя ошибка сервера #3';
            } else {
                $user['links'] = [];

                while($row = mysqli_fetch_array($result)) {
                    array_push(
                        $user['links'],
                        [
                            'link' => $row['Link'],
                            'shortened' => $row['Shortened'],
                            'clicks' => $row['Clicks'],
                            'created' => $row['Created'],
                        ]
                    );
                }
            }
        }
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
    <?php if($user === null) : ?>
        <main>
            <p>Тут какой-нибудь длинный красивый лендинг, рассказывающий почему нужно срочно зарегистрироваться.</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Proin sagittis nisl rhoncus mattis rhoncus urna neque viverra justo. Mi eget mauris pharetra et ultrices neque ornare aenean. Pellentesque elit ullamcorper dignissim cras tincidunt lobortis feugiat vivamus. Id velit ut tortor pretium. Semper feugiat nibh sed pulvinar proin gravida hendrerit. Duis tristique sollicitudin nibh sit amet commodo nulla facilisi nullam. Integer eget aliquet nibh praesent. Euismod in pellentesque massa placerat duis ultricies lacus sed. In hac habitasse platea dictumst vestibulum rhoncus est pellentesque elit.</p>
            <p>Tortor aliquam nulla facilisi cras fermentum odio. Mi in nulla posuere sollicitudin aliquam ultrices sagittis. Amet mattis vulputate enim nulla aliquet porttitor. Malesuada pellentesque elit eget gravida cum sociis natoque penatibus et. Velit laoreet id donec ultrices. Cursus risus at ultrices mi tempus imperdiet nulla. Maecenas pharetra convallis posuere morbi leo urna molestie at elementum. Pharetra et ultrices neque ornare aenean euismod elementum nisi. Blandit cursus risus at ultrices mi tempus imperdiet. Mi in nulla posuere sollicitudin aliquam.</p>
        </main>
    <?php else : ?>
        <main>
            <form class="create" action="/shortener" method="POST">
                Сократить:
                <input required name="link" type="text" placeholder="http://rurururururu.ru/"/>
                <input type="submit"/>
            </form>

            <?php foreach($user['links'] as $link) : ?>
            <div class="link">
                <div class="linkshort">
                    <span>sho.rt/?s=<?= $link['shortened'] ?></span> — переходов: <?= $link['clicks'] ?></div>
                <div class="linkorig">
                    <a href="/shortener/stats.php?s=<?= $link['shortened'] ?>">Подробнее</a>
                    &middot;
                    <a target="_blank" rel="noopener noreferrer" href="<?= $link['link'] ?>">
                        <?= $link['link'] /* без xss-защиты, т. к. не публичный контент */ ?>
                    </a>
                </div>
            </div>
            <?php endforeach ?>
        </main>
    <?php endif ?>
</body>
</html>