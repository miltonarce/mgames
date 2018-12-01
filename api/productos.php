<?php

    //Autoload para las clases
    require '../autoload.php';

    //Content type para devolver JSON
    header('Content-Type: application/json; charset=utf-8');

    //Obtengo el metodo de la petición
    $metodo = $_SERVER['REQUEST_METHOD'];

    //Creo una istancia del producto
    $prod = new Productos;

    //Si es DELETE, elimina el producto
    if ($metodo === 'DELETE' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $success = $prod->deleteById($id);
        if ($success) {
            echo json_encode(['msg'=> 'Se eliminó correctamente el producto', 'status'=> 1]);
        } else {
            echo json_encode(['msg'=> 'Se produjo un error al eliminar el producto', 'status'=> 0]);
        }
    }

    //Si es GET y posee el id muestra el detalle de un sólo producto
    //sino verifica si se esta haciendo una busqueda por el campo search, sino trae todos
    if ($metodo === 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $productFound = $prod->getProductoById($id);
            echo json_encode($productFound);
        } else if(isset($_GET['search'])) {
            $search = $_GET['search'];
            $prods = $prod->filter($search);
            echo json_encode($prods);
        } else {
            $prods = $prod->getProductos();
            echo json_encode($prods);
        }
    } 

    //Si es un PUT, se actualiza el producto
    if ($metodo === 'PUT' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $success = $prod->edit($id, $data);
        if ($success) {
            echo json_encode(['msg'=> 'Se actualizó correctamente el producto', 'status'=> 1]);
        } else {
            echo json_encode(['msg'=> 'Se produjo un error al actualizar el producto', 'status'=> 0]);
        }
    }  

    //Si es un POST, da de alta a un producto
    if ($metodo === 'POST') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $newProduct = $prod->create($data);
        if ($newProduct) {
            echo json_encode(['msg'=> 'Se dio de alta el producto!', 'status'=> 1, 'data'=> $newProduct]);
        } else {
            echo json_encode(['msg'=> 'Se produjo un error al crear el producto', 'status'=> 0, 'data'=> null]);
        }
    }
