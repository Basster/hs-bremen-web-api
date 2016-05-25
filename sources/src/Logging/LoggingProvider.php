<?php

namespace HsBremen\WebApi\Logging;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Silex\Application;
use Silex\ServiceProviderInterface;

class LoggingProvider implements ServiceProviderInterface
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app['api_logger'] = $app->share(function (Application $app) {
            $file = $app['logging_path'] . '/api.log';

            return new Logger('api', [new StreamHandler($file)]);
        });
    }

    /** {@inheritdoc} */
    public function boot(Application $app)
    {
    }
}
