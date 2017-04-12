<?php

namespace rule;

use core\BaseRule;

/**
 * Class CountRule
 * @package rule
 *
 * @property integer $count
 *
 */
class CountRule extends BaseRule
{
    public $count;

    /**
     * @param array $basketProducts
     * @return bool
     */
    public function check($basketProducts = [])
    {
        $count = 0;

        foreach ($basketProducts as $product) {
            if (!$product->discount && !in_array($product->type, $this->exceptProducts)) {
                $count++;
            }
        }

        if ($count >= $this->count) {
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
        if ($this->check($basketProducts)) {
            $ruleSum = 0;
            foreach ($basketProducts as $key => $product) {
                if (!$product->discount && !in_array($product->type, $this->exceptProducts)) {
                    $basketProducts[$key]->discount = true;
                    $ruleSum += $product->price;
                }
            }

            $sum = $ruleSum - ($ruleSum * $this->discount / 100);
        }

        $result = [
            $basketProducts,
            $sum,
        ];

        return $result;
    }
}