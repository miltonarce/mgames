<?php

    //Autoload para las clases
    require '../autoload.php';

    //Content type para devolver JSON
    header('Content-Type: application/json; charset=utf-8');

    //Obtengo el metodo de la petición
    $metodo = $_SERVER['REQUEST_METHOD'];

    //Instancio la clase Auth
    $auth = new Auth;

    //Si es un POST, verifica los datos recibidos y intenta loguear al user...
    if ($metodo === 'POST') {
        $json = file_get_contents('php://input');
        $request = json_decode($json, true);
        $validator = new Validator($request, [
            'username' => ['required'],
            'password' => ['required']
        ]);
        if ($validator->passes()) {
            $success = $auth->login($request['username'], $request['password']);
            if ($success) {
                echo json_encode(['status' => 1, 'msg' => 'Se ha autenticado correctamente!']);
            } else {
                echo json_encode(['status' => 0, 'msg' => 'Usuario o contraseña inválidos, intente nuevamente.']);
            }
        } else {
            echo json_encode(['msg' => $validator->getErrores()->msg , 'status' => 0]);
        }
    }

    //Si es un GET, desloguea el usuario...
    if ($metodo === 'GET') {
        $auth->logout();
        echo json_encode(['status' => 1, 'msg' => 'Se ha deslogueado correctamente!']);
    }