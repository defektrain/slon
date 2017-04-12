<?php

namespace core;

/**
 * Class Product
 * @package core
 *
 * @property string $type
 * @property string $price
 *
 */
class Product
{
    public $type;
    public $price;

    /**
     * Product constructor.
     * @param array $args
     */
    public function __construct($args = [])
    {
        foreach ($args as $key => $item) {
            $this->{$key} = $item;
        }
    }
}