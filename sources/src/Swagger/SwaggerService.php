<?php

namespace HsBremen\WebApi\Swagger;

use Symfony\Component\HttpFoundation\Response;

class SwaggerService
{
    private $basePath;

    /**
     * SwaggerService constructor.
     *
     * @param $basePath
     */
    public function __construct($basePath)
    {
        $this->basePath = $basePath;
    }


    public function generateSwagger()
    {
        $swagger = \Swagger\scan($this->basePath);

        return new Response(
          $swagger, 200, ['Content-Type' => 'application/json']
        );
    }
}
