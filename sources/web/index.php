<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Die Environment Variable ist über die Vagrant VM gesetzt.
// So kann der Debug Modus "dynamisch" gesetzt werden.s
$env = getenv('APP_ENV') ?: 'prod';

$app = new \HsBremen\WebApi\Application(['debug' => $env === 'dev']);
$app->run();
