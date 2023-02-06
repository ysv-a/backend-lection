<?php

//header('Content-Type: text/plain');
// header('Content-Length: 5');
// header('Content-Type: text/plain;charset=cp-1251');
// header('Content-Type: application/pdf');
// header('Content-Type: application/xml');
// header('Content-Type: application/json');

//header('Content-Type: application/pdf');
//header('Content-Type: image/jpeg');
//header('Content-Disposition: attachment; filename="report.pdf"');

// $file = file_get_contents('lorem.txt');
$file = file_get_contents('block45.jpg');
//$file = file_get_contents('sample.pdf');
// $file = file_get_contents('note.xml');
// $file = file_get_contents('test.json');

echo $file;
