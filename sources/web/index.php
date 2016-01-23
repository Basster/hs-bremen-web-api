<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \HsBremen\WebApi\Application();
$app->get('/', function() {
  return 'Hello World';
});

$app->run();
