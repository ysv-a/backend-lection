<?php

setcookie("TestCookie", 5000, [
    'expires' => time()+8000,
    'path' => '/index.php',
    'samesite' => 'lax'
]);


echo "<pre>";
var_dump($_COOKIE);

var_dump($_POST);
echo "</pre>";
