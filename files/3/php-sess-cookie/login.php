<?php

session_save_path('sessions');
session_name("my_app");
session_start([
    'cookie_httponly' => true,
]);


$list_user = [
    ['id' => 1, 'email' => 'example@test.com', 'remember_identifier' => 'test_identifier'],
    ['id' => 2, 'email' => 'example@test2.com', 'remember_identifier' => 'test_identifier2'],
];

$email = @$_POST['email'];
// $remember = @$_POST['remember_me'];


$user = array_filter($list_user, function($user) use($email){
    return $user['email'] === $email;
});

if($user){

    // if($remember){
    //     setcookie("remember", "test_identifier", [
    //         'expires' => time() + 86400,
    //         'httpOnly' => true
    //     ]);
    // }


    $_SESSION['user'] = $user[0];
    header('Location: http://localhost:8000/restrict.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
<form method="POST" action="/login.php">
  <div class="form-group">
    <label for="exampleInputEmail1">Email address</label>
    <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
  </div>
  <div class="form-group form-check">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
    <input type="checkbox" name="remember_me" class="form-check-input" id="exampleCheck1">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
</body>
</html>
