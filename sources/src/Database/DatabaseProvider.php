<?php

namespace HsBremen\WebApi\Database;

use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\ServiceProviderInterface;

class DatabaseProvider implements ServiceProviderInterface
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app['db_user']     = 'root';
        $app['db_password'] = '123';

        $app->register(
          new DoctrineServiceProvider(),
          [
            'db.options' => [
              'driver'   => 'pdo_mysql',
              'host'     => 'localhost',
              'dbname'   => 'web_api',
              'user'     => $app['db_user'],
              'password' => $app['db_password'],
            ],
          ]
        );
    }

    /** {@inheritdoc} */
    public function boot(Application $app)
    {
    }
}
