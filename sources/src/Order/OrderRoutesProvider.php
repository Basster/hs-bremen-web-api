<?php

namespace HsBremen\WebApi\Order;

use Silex\Application;
use Silex\ControllerCollection;
use Silex\ControllerProviderInterface;
use Swagger\Annotations as SWG;

class OrderRoutesProvider implements ControllerProviderInterface
{
    /** {@inheritdoc} */
    public function connect(Application $app)
    {
        /** @var ControllerCollection $controllers */
        $controllers = $app['controllers_factory'];

        /**
         * @SWG\Parameter(name="id-in-path", type="integer", format="int32", in="path")
         */

        /**
         * @SWG\Get(
         *     path="/order",
         *     @SWG\Response(response="200", description="An example resource")
         * )
         */
        $controllers->get('', 'service.order:getList');
        /**
         * @SWG\Get(
         *     path="/order/{orderId}",
         *     @SWG\Parameter(ref="#/parameters/id-in-path", name="orderId"),
         *     @SWG\Response(
         *         response="200",
         *         description="An example resource",
         *          @SWG\Schema(ref="#/definitions/order")
         *     )
         * )
         */
        $controllers->get('/{orderId}', 'service.order:getDetails');
        /**
         * @SWG\Post(
         *     path="/order",
         *     @SWG\Parameter(name="order", in="body", @SWG\Schema(ref="#/definitions/order")),
         *     @SWG\Response(response="201", description="An example resource")
         * )
         */
        $controllers->post('', 'service.order:createOrder');
        /**
         * @SWG\Put(
         *     path="/order/{orderId}",
         *     @SWG\Parameter(ref="#/parameters/id-in-path", name="orderId"),
         *     @SWG\Response(
         *          response="200",
         *          description="An example resource",
         *          @SWG\Schema(ref="#/definitions/order")
         *     )
         * )
         */
        $controllers->put('/{orderId}', 'service.order:changeOrder');

        return $controllers;
    }
}
