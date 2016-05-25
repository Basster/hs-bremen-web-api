<?php

namespace HsBremen\WebApi\Database;

use Exception;
use HsBremen\WebApi\Error\ApiErrorCode;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class DatabaseException extends \Exception implements HttpExceptionInterface
{
    public function __construct($message)
    {
        parent::__construct($message, ApiErrorCode::DATABASE_ERROR);
    }

    /** {@inheritdoc} */
    public function getStatusCode()
    {
        return Response::HTTP_NOT_FOUND;
    }

    /** {@inheritdoc} */
    public function getHeaders()
    {
        return [];
    }
}
