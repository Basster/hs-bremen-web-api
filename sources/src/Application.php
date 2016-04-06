<?php

namespace HsBremen\WebApi;

use HsBremen\WebApi\Order\OrderService;
use Silex\Application as Silex;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Request;

class Application extends Silex
{
    public function __construct(array $values = [])
    {
        parent::__construct($values);
        $this->register(new ServiceControllerServiceProvider());

        $app = $this;

        $app['service.order'] = $app->share(function () {
            return new OrderService();
        });

        $this->get('/order', 'service.order:getList');

        $this->get('/order/{orderId}', 'service.order:getDetails');
        $this->post('/order', 'service.order:createOrder');
        $this->put('/order/{orderId}', 'service.order:changeOrder');

        // http://silex.sensiolabs.org/doc/cookbook/json_request_body.html
        $this->before(function (Request $request) {
            if (0 === strpos($request->headers->get('Content-Type'),
                'application/json')
            ) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : []);
            }
        });
    }
}
