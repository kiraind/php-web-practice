<?php
    setcookie('token', 'deteled', time()-3600);

    $host = $_SERVER['HTTP_HOST'];
    header("Location: http://$host/shortener");
?>