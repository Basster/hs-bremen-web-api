<?php


namespace HsBremen\WebApi\Tests\Order;


use HsBremen\WebApi\Order\OrderRoutesProvider;
use Silex\Application;
use Silex\ControllerCollection;

class OrderRoutesProviderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function registerIndexRoute()
    {
        $provider = new OrderRoutesProvider();

        $controllerFactory = $this->prophesize(ControllerCollection::class);
        $controllerFactory->get('', 'service.order:getList')->shouldBeCalled();
        $controllerFactory->get('/{orderId}', 'service.order:getDetails')
                          ->shouldBeCalled()
        ;
        $controllerFactory->post('', 'service.order:createOrder')
                          ->shouldBeCalled()
        ;
        $controllerFactory->put('/{orderId}', 'service.order:changeOrder')
                          ->shouldBeCalled()
        ;

        $app                        = new Application();
        $app['controllers_factory'] = $controllerFactory->reveal();
        $provider->connect($app);
    }

}
