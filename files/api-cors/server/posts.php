<?php

require 'header.php';


$data = ['status' => 'OK'];
$payload = json_encode($data);

echo $payload;

die;
