<?php

require 'header.php';

header('Content-Type: application/pdf');
header('X-File-Name: report.pdf');
header('Content-Disposition: attachment; filename="report.pdf"');

$file = file_get_contents('sample.pdf');

echo $file;
