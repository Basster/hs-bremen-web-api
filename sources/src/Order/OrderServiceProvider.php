<?php

namespace HsBremen\WebApi\Order;

use HsBremen\WebApi\Logging\DomainLogger;
use Silex\Application;
use Silex\ServiceProviderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OrderServiceProvider implements ServiceProviderInterface
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app['repo.order'] = $app->share(function (Application $app) {
            return new OrderRepository($app['db']);
        });

        $app['service.order'] = $app->share(function (Application $app) {
            return new OrderService($app['repo.order'], $app['dispatcher']);
        });

        $app['subscriber.order_domain'] = $app->share(
          function (Application $app) {
              return new OrderDomainEventSubscriber($app['repo.order']);
          }
        );

        $app['subscriber.domain_logger'] = $app->share(
          function (Application $app) {
              return new DomainLogger($app['api_logger']);
          }
        );

        /** @var EventDispatcherInterface $dispatcher */
        $dispatcher = $app['dispatcher'];
        $dispatcher->addSubscriber($app['subscriber.domain_logger']);
        $dispatcher->addSubscriber($app['subscriber.order_domain']);

        $app->mount('/order', new OrderRoutesProvider());
    }

    /** {@inheritdoc} */
    public function boot(Application $app)
    {
        /** @var OrderRepository $repo */
        $repo = $app['repo.order'];
        $repo->createTable();
    }
}
