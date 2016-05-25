<?php

namespace HsBremen\WebApi\Error;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class ErrorProvider implements ServiceProviderInterface
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app['subscriber.kernel_excption'] = $app->share(
          function (Application $app) {
              return new UnhandledExceptionSubscriber($app['debug']);
          }
        );

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = $app['dispatcher'];
        $dispatcher->addSubscriber($app['subscriber.kernel_excption']);
    }

    /** {@inheritdoc} */
    public function boot(Application $app)
    {
    }
}
