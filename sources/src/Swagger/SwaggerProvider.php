<?php

namespace HsBremen\WebApi\Swagger;

use Silex\Application;
use Silex\ServiceProviderInterface;
use Swagger\Annotations as SWG;

class SwaggerProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given app.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     */
    public function register(Application $app)
    {
        $app['service.swagger'] = $app->share(function (Application $app) {
            return new SwaggerService($app['base_path']);
        });

        /**
         * @SWG\Get(
         *     path="/docs/swagger.json",
         *     @SWG\Response(response="200", description="swagger documentation")
         * )
         */
        $app->get('/docs/swagger.json', 'service.swagger:generateSwagger');
    }

    /**
     * Bootstraps the application.
     *
     * This method is called after all services are registered
     * and should be used for "dynamic" configuration (whenever
     * a service must be requested).
     */
    public function boot(Application $app)
    {
    }
}
