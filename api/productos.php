<?php
header('Content-Type: application/json; charset=utf-8');

require '../autoload.php';
$prod = new Productos;
$prods = $prod->getProductos();

echo json_encode($prods);
