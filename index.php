<?php

require(__DIR__ . '/core/Basket.php');
require(__DIR__ . '/core/Product.php');
require(__DIR__ . '/core/Rule.php');
require(__DIR__ . '/core/BaseRule.php');
require(__DIR__ . '/rule/CountRule.php');
require(__DIR__ . '/rule/ProductRule.php');
require(__DIR__ . '/rule/ProductOneOfRule.php');

use core\Basket;
use core\Product;
use rule\CountRule;
use rule\ProductRule;
use rule\ProductOneOfRule;

//init basket
$basket = new Basket();

//add products to basket
$basket->addProduct(new Product([
    'type' => 'A',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'B',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'C',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'D',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'E',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'F',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'G',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'H',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'I',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'J',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'K',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'L',
    'price' => 100,
]));
$basket->addProduct(new Product([
    'type' => 'M',
    'price' => 100,
]));

//apply rules to basket
$basket->addRule(new ProductRule([
    'products' => [
        'A',
        'B',
    ],
    'discount' => 10,
    'exceptRules' => [
        CountRule::class,
    ],
]));
$basket->addRule(new ProductRule([
    'products' => [
        'D',
        'E',
    ],
    'discount' => 5,
]));
$basket->addRule(new ProductRule([
    'products' => [
        'E',
        'F',
        'G',
    ],
    'discount' => 5,
]));
$basket->addRule(new ProductOneOfRule([
    'baseProduct' => 'A',
    'products' => [
        'K',
        'L',
        'M',
    ],
    'discount' => 5,
]));
$basket->addRule(new CountRule([
    'count' => 3,
    'discount' => 5,
    'exceptProducts' => [
        'A',
        'C',
    ],
]));
$basket->addRule(new CountRule([
    'count' => 4,
    'discount' => 10,
    'exceptProducts' => [
        'A',
        'C',
    ],
]));
$basket->addRule(new CountRule([
    'count' => 5,
    'discount' => 20,
    'exceptProducts' => [
        'A',
        'C',
    ],
]));

echo "Count: " . count($basket->products);
echo "\n<br>";
echo "Total: " . $basket->calculate(false);
echo "\n<br>";
echo "Total with discounts: " . $basket->calculate();
echo "\n<br>";
echo "Excepted rules: " . count($basket->exceptRules);
echo "\n<br>";
foreach ($basket->exceptRules as $item) {
    echo $item."\n<br>";
}