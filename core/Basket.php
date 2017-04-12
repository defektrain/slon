<?php

namespace core;

/**
 * Class Basket
 * @package core
 *
 * @property [] $products
 * @property [] $rules
 * @property [] $exceptRules
 *
 */
class Basket
{
    public $products = [];
    public $rules = [];
    public $exceptRules = [];

    /**
     * @param Product $product
     */
    public function addProduct(Product $product)
    {
        $this->products[] = $product;
    }

    /**
     * @param BaseRule $rule
     */
    public function addRule(BaseRule $rule)
    {
        $this->rules[] = $rule;
    }

    /**
     * @param bool $applyRules
     * @return int
     */
    public function calculate($applyRules = true)
    {
        $sum = 0;

        if ($applyRules) {
            foreach ($this->rules as $item) {
                if (!in_array(get_class($item), $this->exceptRules)) {
                    if ($item->check($this->products)) {
                        list($this->products, $sum) = $item->apply($this->products, $sum);
                        if ($item->exceptRules) {
                            $this->exceptRules = array_merge($this->exceptRules, $item->exceptRules);
                        }
                    }
                }
            }
        }

        foreach ($this->products as $item) {
            if (!$item->discount) {
                $sum += $item->price;
            }
        }

        return $sum;
    }
}