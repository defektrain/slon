<?php

namespace core;

/**
 * Interface Rule
 * @package core
 */
interface Rule
{
    /**
     * @param array $basketProducts
     * @return mixed
     */
    public function check($basketProducts = []);

    /**
     * @param array $basketProducts
     * @param int $sum
     * @return mixed
     */
    public function apply($basketProducts = [], $sum = 0);
}