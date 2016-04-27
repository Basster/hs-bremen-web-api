<?php

namespace HsBremen\WebApi\Security;

use Silex\Application;
use Silex\Provider\SecurityServiceProvider;
use Silex\ServiceProviderInterface;

class SecurityProvider implements ServiceProviderInterface
{

    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app->register(new SecurityServiceProvider());

        $app['security.firewalls'] = [
          'admin' => [
              // RegEx
              'pattern' => '^/',
              // HTTP-Basic Auth flag
              'http'    => true,
              // Users array
              'users'   => [
                  // raw password is foo
                  'admin' => [
                    'ROLE_ADMIN',
                    '5FZ2Z8QIkA7UTZ4BYkoC+GsReLf569mSKDsfods6LYQ8t+a8EW9oaircfMpmaLbPBh4FOBiiFyLfuZmTSUwzZg==',
                  ],
              ],
          ],
        ];
    }

    /** {@inheritdoc} */
    public function boot(Application $app)
    {
    }
}
