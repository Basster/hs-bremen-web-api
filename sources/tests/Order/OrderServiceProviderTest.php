<?php


namespace HsBremen\WebApi\Tests\Order;


use HsBremen\WebApi\Order\OrderService;
use HsBremen\WebApi\Order\OrderServiceProvider;
use Silex\Application;

class OrderServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function orderServiceIsRegistered()
    {
        $provider = new OrderServiceProvider();
        $app      = new Application();
        $provider->register($app);

        self::assertArrayHasKey('service.order', $app);
        self::assertInstanceOf(OrderService::class, $app['service.order']);
    }
}
