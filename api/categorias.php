<?php
header('Content-Type: application/json; charset=utf-8');

require '../autoload.php';

$categs = new Categorias;

$categorias = $categs->getCategorias();

echo json_encode($categorias);