<?php

require 'header.php';

setcookie("TestCookie3", 'something from somewhere', [
    'expires' => time() + 60*60*24*30,
    'path' => '/',
    'domain' => 'localhost',
    'SameSite' => 'None',
    'secure' => true,
    'httponly' => false
]);

$data = ['status' => 'OK'];
$payload = json_encode($data);

echo $payload;

die;
