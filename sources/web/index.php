<?php

require_once __DIR__ . '/../vendor/autoload.php';

$app = new \HsBremen\WebApi\Application(['debug' => true]);
$app->run();
