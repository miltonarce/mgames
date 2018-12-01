<?php

    //Autoload para las clases
    require '../autoload.php';

    //Content type para devolver JSON
    header('Content-Type: application/json; charset=utf-8');

    //Obtengo el metodo de la petición
    $metodo = $_SERVER['REQUEST_METHOD'];

    //Creo una istancia de los tipos
    $type = new Tipos;

    //Si es un GET, trae todas los tipos
    if ($metodo === 'GET') {
        $tipos = $type->getTipos();
        echo json_encode($tipos);
    }