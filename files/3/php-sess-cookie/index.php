<?php

session_save_path('sessions');
session_name("custom_web_site");
session_start([
    'cookie_lifetime' => 7878787,
    'cookie_httponly' => true,
]);

// session_regenerate_id();

// Повторное создание идентификатора сеанса часто выполняется для предотвращения использования злонамеренными пользователями атаки фиксации сеанса на ваше приложение.

if (empty($_SESSION['count'])) {
   $_SESSION['count'] = 1;
} else {
   $_SESSION['count']++;
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session</title>
</head>
<body>
    <h1>Count: <?php echo $_SESSION['count']; ?></h1>
</body>
</html>
