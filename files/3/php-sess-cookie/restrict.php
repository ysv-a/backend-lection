<?php

// $list_user = [
//     ['id' => 1, 'email' => 'example@test.com', 'remember_identifier' => 'test_identifier'],
//     ['id' => 2, 'email' => 'example@test2.com', 'remember_identifier' => 'test_identifier2'],
// ];

session_save_path('sessions');
session_name("my_app");
session_start([
    'cookie_httponly' => true,
]);

$user = @$_SESSION['user'];
// $remember = @$_COOKIE['remember'];

// if($remember){
//     $user = array_filter($list_user, function($user) use($remember){
//         return $user['remember_identifier'] === $remember;
//     });
//     if(empty($user)){
//         header("HTTP/1.0 404 Not Found");
//         die();
//     }


//     $_SESSION['user'] = $user[0];
//     $user = $user[0];
// }

if(empty($user)){
    header("HTTP/1.0 404 Not Found");
    die();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrict Page</title>
</head>
<body>
    <h1><?php echo $user['email']; ?></h1>
    <h2><?php echo $user['id']; ?></h2>
</body>
</html>
