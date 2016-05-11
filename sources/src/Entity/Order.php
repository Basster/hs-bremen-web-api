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

    public function __construct($id = null)
    {
        $this->id = $id;
    }

    public static function createFromArray(array $row)
    {
        $order = new self();
        if (array_key_exists('id', $row)) {
            $order->setId($row['id']);
        }
        $order->setStatus($row['status']);

        return $order;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
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

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }
}
