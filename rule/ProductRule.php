<?php

namespace rule;

use core\BaseRule;

/**
 * Class ProductRule
 * @package rule
 *
 * @property [] $products
 *
 */
class ProductRule extends BaseRule
{
    public $products = [];

    /**
     * @param array $basketProducts
     * @return bool
     */
    public function check($basketProducts = [])
    {
        $found = [];

        foreach ($basketProducts as $product) {
            if (!$product->discount && !in_array($product->type, $this->exceptProducts)) {
                if (in_array($product->type, $this->products) && !in_array($product->type, $found)) {
                    $found[] = $product->type;
                }
            }
        }

        if (!array_diff($this->products, $found)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param array $basketProducts
     * @param int $sum
     * @return array
     */
    public function apply($basketProducts = [], $sum = 0)
    {
        $used = [];

        while ($this->check($basketProducts)) {
            $used = $used + $this->_getUsed($basketProducts);
            $basketProducts = array_replace($basketProducts, $used);
        }

        $sum += $this->_getSum($used);

        $result = [
            $basketProducts,
            $sum,
        ];

        return $result;
    }

    /**
     * @param array $basketProducts
     * @return array
     */
    private function _getUsed($basketProducts = [])
    {
        $found = [];
        $foundProducts = [];

        foreach ($basketProducts as $key => $product) {
            if (!$product->discount && !in_array($product->type, $this->exceptProducts)) {
                if (in_array($product->type, $this->products) && !in_array($product->type, $found)) {
                    $found[] = $product->type;
                    $product->discount = true;
                    $foundProducts[$key] = $product;
                }
            }
        }

        if ($foundProducts && !array_diff($this->products, $found)) {
            return $foundProducts;
        } else {
            return [];
        }
    }

    /**
     * @param array $products
     * @return int
     */
    private function _getSum($products = [])
    {
        $sum = 0;

        foreach ($products as $product) {
            $sum += $product->price;
        }

        $sum = $sum - ($sum * $this->discount / 100);

        return $sum;
    }
}