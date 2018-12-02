<?php

    //Autoload para las clases
    require '../autoload.php';

    //Content type para devolver JSON
    header('Content-Type: application/json; charset=utf-8');

    //Obtengo el metodo de la petición
    $metodo = $_SERVER['REQUEST_METHOD'];

    //Creo una istancia de los tipos
    $type = new Tipos;

    //Si es DELETE, elimina el tipo
    if ($metodo === 'DELETE' && isset($_GET['id'])) {
        $id = $_GET['id'];
        try {
            $success = $type->remove($id);
            if ($success) {
                echo json_encode(['msg'=> 'Se eliminó correctamente el tipo', 'status'=> 1]);
            } else {
                echo json_encode(['msg'=> 'Se produjo un error al eliminar el tipo', 'status'=> 0]);
            }
        } catch(NoExisteException $e) {
            echo json_encode(['msg' => $e->getMessage(), 'status' => 0]);
        }
    }

    //Si es GET y posee el id muestra el detalle de una sólo tipo, sino trae todos
    if ($metodo === 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            try {
                $typeFound = $type->find($id);
                echo json_encode($typeFound);
            } catch(NoExisteException $e) {
               echo json_encode(['msg' => $e->getMessage(), 'status' => 0]);
            }
        } else {
            $types = $type->all();
            echo json_encode($types);
        }
    }

    //Si es un PUT, se actualiza la categoría
    if ($metodo === 'PUT' && isset($_GET['id'])) {
        $id = $_GET['id'];
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $validator = new Validator($data, [
            'tipo' => ['required', 'min:3'],
        ]);
        if ($validator->passes()) {
            $success = $type->update($id, $data);
            if ($success) {
                echo json_encode(['msg'=> 'Se actualizó correctamente el tipo', 'status'=> 1]);
            } else {
                echo json_encode(['msg'=> 'Se produjo un error al actualizar el tipo', 'status'=> 0]);
            }
        } else {
            echo json_encode(['errors' => $validator->getErrores(), 'status' => 0, 'data' => null]);
        }
    }  

    //Si es un POST, da de alta a un tipo
    if ($metodo === 'POST') {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $validator = new Validator($data, ['tipo' => ['required', 'min:3']]);
        if ($validator->passes()) {
            $newType = $type->save($data);
            if ($newType) {
                echo json_encode(['msg'=> 'Se dio de alta el tipo!', 'status'=> 1, 'data'=> $newProduct]);
            } else {
                echo json_encode(['msg'=> 'Se produjo un error al crear el tipo', 'status'=> 0, 'data'=> null]);
            }
        } else {
            echo json_encode(['errors' => $validator->getErrores(), 'status' => 0, 'data' => null]);
        }
    }