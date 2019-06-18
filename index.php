<?php

/* pre define */
header('Content-Type: application/json');
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

/* read data */
$productData = json_decode(file_get_contents("data/products.json"), true);
$stockData = json_decode(file_get_contents("data/stock.json"), true);
$locationData = json_decode(file_get_contents("data/locations.json"), true);

/* class dependencie */
require_once('lib/orami.php');

/* define product object */
$product = new Product($productData, $stockData, $locationData);

/* run to get product detail */
$product->run();


