<?php
header('Content-Type: application/json; charset=utf-8');

require '../autoload.php';

$tips = new Tipos;

$tipos = $tips->getTipos();

echo json_encode($tipos);