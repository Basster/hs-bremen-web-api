<?php

namespace HsBremen\WebApi;

use Basster\Silex\Provider\Swagger\SwaggerProvider;
use Basster\Silex\Provider\Swagger\SwaggerServiceKey;
use HsBremen\WebApi\Order\OrderServiceProvider;
use HsBremen\WebApi\Security\SecurityProvider;
use JDesrosiers\Silex\Provider\CorsServiceProvider;
use Silex\Application as Silex;
use Silex\Provider\ServiceControllerServiceProvider;
use Swagger\Annotations as SWG;
use SwaggerUI\Silex\Provider\SwaggerUIServiceProvider;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Application
 *
 * @package HsBremen\WebApi
 * @SWG\Swagger(
 *     consumes={"application/json"},
 *     produces={"application/json"},
 *     basePath="/",
 *     host="web-api.vm"
 * )
 * @SWG\Info(
 *     title="My First API",
 *     version="0.1"
 * )
 */
class Application extends Silex
{
    public function __construct(array $values = [])
    {
        parent::__construct($values);
        $this->register(new ServiceControllerServiceProvider());

        $app = $this;

        $app['base_path'] = __DIR__;

        $this->register(new SwaggerProvider(), [
          SwaggerServiceKey::SWAGGER_SERVICE_PATH => $app['base_path'],
          SwaggerServiceKey::SWAGGER_API_DOC_PATH => '/docs/swagger.json',
        ]);

        $app->register(new SwaggerUIServiceProvider(), [
          'swaggerui.path' => '/docs/swagger',
          'swaggerui.docs' => '/docs/swagger.json',
        ]);

        // enable cross origin requests!
        $app->register(new CorsServiceProvider());

        // al about orders
        $this->register(new OrderServiceProvider());
        $this->register(new SecurityProvider());

        // http://silex.sensiolabs.org/doc/cookbook/json_request_body.html
        $this->before(function (Request $request) use ($app) {
            if ($app->requestIsJson($request)) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : []);
            }
        });

        $app->after($app['cors']);
    }

    private function requestIsJson(Request $request)
    {
        return 0 === strpos(
          $request->headers->get('Content-Type'),
          'application/json'
        );
    }
}
