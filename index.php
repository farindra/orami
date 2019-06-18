<?php

/* pre define */
header('Content-Type: application/json');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/* data define */
$productData = [
    [
        "productId" => 1000,
        "productName" => "Product 1000"
    ],
    [
        "productId" => 1001,
        "productName" => "Product 1001"
    ],
];

$stockData = [
    [
        "productId" => 1000,
        "locationId" => 1,
        "stock" => 21
    ],
    [
        "productId" => 1000,
        "locationId" => 2,
        "stock" => 8
    ],
    [
        "productId" => 1001,
        "locationId" => 1,
        "stock" => 4
    ],
    [
        "productId" => 1001,
        "locationId" => 2,
        "stock" => 10
    ]
];

$locationData = [
    [
        "locationId" => 1,
        "locationName" => "Location 1"
    ],
    [
        "locationId" => 2,
        "locationName" => "Location 2"
    ]
];

/* class dependencie */
require_once('orami.php');

/* define product object */
$product = new Product($productData, $stockData, $locationData);

/* run to get product detail */
$product->run();


