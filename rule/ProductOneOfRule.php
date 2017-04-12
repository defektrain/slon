<?php

namespace rule;

use core\BaseRule;

/**
 * Class ProductOneOfRule
 * @package rule
 *
 * @property string $baseProduct
 * @property [] $products
 *
 */
class ProductOneOfRule extends BaseRule
{
    public $baseProduct;
    public $products = [];

    /**
     * @param array $basketProducts
     * @return bool
     */
    public function check($basketProducts = [])
    {
        $foundBase = false;
        $found = false;

        foreach ($basketProducts as $product) {
            if (!$product->discount && !in_array($product->type, $this->exceptProducts)) {
                if ($this->baseProduct == $product->type) {
                    $foundBase = true;
                } elseif (in_array($product->type, $this->products)) {
                    $found = true;
                }

                if ($found && $foundBase) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param array $basketProducts
     * @param int $sum
     * @return array
     */
    public function apply($basketProducts = [], $sum = 0)
    {
        $used = $this->_getUsed($basketProducts);

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
        $foundBase = false;
        $found = false;
        $foundProducts = [];

        foreach ($basketProducts as $key => $product) {
            if (!$product->discount && !in_array($product->type, $this->exceptProducts)) {
                if ($this->baseProduct == $product->type) {
                    $foundBase = true;
                    $product->discount = true;
                    $foundProducts[$key] = $product;
                } elseif (in_array($product->type, $this->products)) {
                    $found = true;
                    $product->discount = true;
                    $foundProducts[$key] = $product;
                }

                if ($found && $foundBase) {
                    return $foundProducts;
                }
            }
        }

        return [];
    }

    /**
     * @param array $products
     * @return int
     */
    public function _getSum($products = [])
    {
        $sum = 0;

        foreach ($products as $item) {
            $sum += $item->price;
        }

        $sum = $sum - ($sum * $this->discount / 100);

        return $sum;
    }
}