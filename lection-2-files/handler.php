<?php

// $entityBody = file_get_contents('php://input');

echo "<pre>";
var_dump($_GET);
echo "</pre> <hr>";

echo "<pre>";
var_dump($_POST);
echo "</pre> <hr>";

echo "<pre>";
var_dump($_FILES);
echo "</pre> <hr>";

echo "<pre>";
var_dump($_REQUEST);
echo "</pre> <hr>";

// echo "<pre>";
// var_dump($entityBody);

// $json = json_decode($entityBody, 1);
// var_dump($json);
// echo "</pre> <hr>";
