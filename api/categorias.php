<?php

    //Autoload para las clases
    require '../autoload.php';

    //Content type para devolver JSON
    header('Content-Type: application/json; charset=utf-8');

    //Obtengo el metodo de la petición
    $metodo = $_SERVER['REQUEST_METHOD'];

    //Creo una istancia de las categorías
    $cat = new Categorias;

    //Si es un GET, trae todas las categorias
    if ($metodo === 'GET') {
        $categorias = $cat->all();
        echo json_encode($categorias);
    }