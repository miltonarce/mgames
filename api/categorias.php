<?php

    //Autoload para las clases
    require '../autoload.php';

    //Content type para devolver JSON
    header('Content-Type: application/json; charset=utf-8');

    //Obtengo el metodo de la petición
    $metodo = $_SERVER['REQUEST_METHOD'];
    
    //Creo una instancia de la categoría
    $cat = new Categorias;

    //Si es DELETE, elimina el producto
    if ($metodo === 'DELETE' && isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $success = $cat->remove($id);
            if ($success) {
                echo json_encode(['msg'=> 'Se eliminó correctamente la categoría', 'status'=> 1]);
            } else {
                echo json_encode(['msg'=> 'Se produjo un error al eliminar la categoría', 'status'=> 0]);
            }
        } catch(NoExisteException $e) {
            echo json_encode(['msg' => $e->getMessage(), 'status' => 0]);
        }
    }

    //Si es GET y posee el id muestra el detalle de una sóla categoría, sino trae todos
    if ($metodo === 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $catFound = $cat->find($id);
                echo json_encode($catFound);
            } catch(NoExisteException $e) {
               echo json_encode(['msg' => $e->getMessage(), 'status' => 0]);
            }
        } else {
            $categorias = $cat->all();
            echo json_encode($categorias);
        }
    }

    //Si es un PUT, se actualiza la categoría
    if ($metodo === 'PUT' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $validator = new Validator($data, [
            'categoria' => ['required', 'min:3'],
        ]);
        if ($validator->passes()) {
            $success = $cat->update($id, $data);
            if ($success) {
                echo json_encode(['msg'=> 'Se actualizó correctamente la categoría', 'status'=> 1]);
            } else {
                echo json_encode(['msg'=> 'Se produjo un error al actualizar la categoría', 'status'=> 0]);
            }
        } else {
            echo json_encode(['errors' => $validator->getErrores(), 'status' => 0, 'data' => null]);
        }
    }  

    //Si es un POST, da de alta a una categoría
    if ($metodo === 'POST') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $validator = new Validator($data, ['categoria' => ['required', 'min:3']]);
        if ($validator->passes()) {
            $newCat = $cat->save($data);
            if ($newCat) {
                echo json_encode(['msg'=> 'Se dio de alta la categoría!', 'status'=> 1, 'data'=> $newProduct]);
            } else {
                echo json_encode(['msg'=> 'Se produjo un error al crear la categoría', 'status'=> 0, 'data'=> null]);
            }
        } else {
            echo json_encode(['errors' => $validator->getErrores(), 'status' => 0, 'data' => null]);
        }
    }