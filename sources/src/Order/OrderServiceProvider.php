<?php

namespace HsBremen\WebApi\Order;

use Silex\Application;
use Silex\ServiceProviderInterface;

class OrderServiceProvider implements ServiceProviderInterface
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app['repo.order'] = $app->share(function (Application $app) {
            return new OrderRepository($app['db']);
        });

        $app['service.order'] = $app->share(function (Application $app) {
            return new OrderService($app['repo.order']);
        });

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
