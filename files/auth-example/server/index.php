<?php

require 'header.php';


$data = ['name' => 'Bob', 'age' => 40];
$payload = json_encode($data);

echo $payload;

die;
