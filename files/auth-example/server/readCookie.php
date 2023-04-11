<?php

require 'header.php';


$data = ['cookie' => $_COOKIE["TestCookie3"]];
$payload = json_encode($data);

echo $payload;

die;
