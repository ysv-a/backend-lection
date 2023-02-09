<?php

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

$value = Yaml::parseFile('yaml-example.yml');

// dump($value);

// $xml_file = file_get_contents('xml-example.xml');
// $xml = simplexml_load_string($xml_file);
// https://www.php.net/manual/en/simplexmlelement.attributes.php


//dump($xml->plant->zone);