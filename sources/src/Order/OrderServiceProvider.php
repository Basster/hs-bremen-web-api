<?php

namespace HsBremen\WebApi\Order;

use Silex\Application;
use Silex\ServiceProviderInterface;

class OrderServiceProvider implements ServiceProviderInterface
{
    /** {@inheritdoc} */
    public function register(Application $app)
    {
        $app['service.order'] = $app->share(function () {
            return new OrderService();
        });

        $app->mount('/order', new OrderRoutesProvider());
    }

    /** {@inheritdoc} */
    public function boot(Application $app)
    {
    }
}
