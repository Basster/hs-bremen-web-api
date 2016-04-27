<?php

namespace HsBremen\WebApi\Entity;

use Swagger\Annotations as SWG;

/**
 * Class Order
 *
 * @package HsBremen\WebApi\Entity
 * @SWG\Definition(
 *     definition="order",
 *     type="object"
 * )
 */
class Order implements \JsonSerializable
{

    /**
     * @var int
     * @SWG\Property(type="integer", format="int32")
     */
    private $id;

    /**
     * @var string
     * @SWG\Property(type="string")
     */
    private $status = 'placed';

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function jsonSerialize()
    {
        return [
          'id'     => $this->id,
          'status' => $this->status,
        ];
    }
}
