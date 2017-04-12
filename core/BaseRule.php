<?php

namespace core;

/**
 * Class BaseRule
 * @package core
 *
 * @property [] $discount
 * @property [] $exceptProducts
 * @property [] $exceptRules
 *
 */
abstract class BaseRule implements Rule
{
    public $discount = 0;
    public $exceptProducts = [];
    public $exceptRules = [];

    /**
     * BaseRule constructor.
     * @param array $args
     */
    public function __construct($args = [])
    {
        foreach ($args as $key => $item) {
            $this->{$key} = $item;
        }
    }
}