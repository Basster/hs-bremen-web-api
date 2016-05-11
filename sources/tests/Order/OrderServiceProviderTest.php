<?php


namespace HsBremen\WebApi\Tests\Order;


use Doctrine\DBAL\Connection;
use HsBremen\WebApi\Order\OrderRepository;
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
        $orderRepo = self::getMockBuilder(OrderRepository::class)
                         ->disableOriginalConstructor()
                         ->getMock()
        ;

        $connection = self::getMockBuilder(Connection::class)
                          ->disableOriginalConstructor()
                          ->getMock()
        ;

        $provider = new OrderServiceProvider();
        $app      = new Application();

        $app['repo.order'] = $orderRepo;
        $app['db']         = $connection;

        $provider->register($app);

        self::assertArrayHasKey('service.order', $app);
        self::assertInstanceOf(OrderService::class, $app['service.order']);
    }
}
