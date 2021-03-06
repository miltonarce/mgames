<?php
  //Autoload para las clases
  require 'autoload.php';
  //Verificamos si el usuario no esta logueado y quiere acceder, se redirige al index...
  if (!Auth::isLogged()) {
    header('Location: login.php');
    exit;
  }
?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Millennial Games</title>
    <link rel="stylesheet" href="css/dist/css/bootstrap.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  </head>
  <body>
    <div class="container-main container-fluid">
      <header>
        <nav class="navbar navbar-light bg-light">
          <a href="index.php"><h1 class="logo">Millennial Games</h1></a>
          <ul class="nav justify-content-end">
            <li class="nav-item">
            <a class="nav-link" href="#"> Bienvenido! 
              <span class="badge badge-light"><?= unserialize(Session::get('USER_LOGGED_IN'))->getUsuario() ?></span>
            </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php" id="logout">Cerrar Sesión</a>
            </li>
          </ul>
        </nav>
      </header>
      <div class="d-flex justify-content-center">
        <div id="msg"></div>
        <main id="main-cont" class="editmain"> 
          <div class="container">
            <div class="row add">
              <div class="col"></div>
              <div class="col">
                <a class="btn btn-primary btn-lg btn-block" href="agregar-prod.php" role="button">Agregar nuevo producto</a>
              </div>
              <div class="col"></div>
            </div>
          </div>
          <div class="row">
            <table class="table text-center text-justify table-hover table-light">
              <thead class="thead-light">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Imagen</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Descripción</th>
                  <th scope="col">Stock</th>
                  <th scope="col">Precio</th>
                  <th scope="col">Fecha</th>
                  <th scope="col">Categoría</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Editar</th>
                  <th scope="col">Eliminar</th>
                </tr>
              </thead>
              <tbody id="items"></tbody>
            </table>
          </div>
        </div>
        </main>
        <footer class="footer d-flex justify-content-end">
          <p>Tp1 by Matias Torre - Milton Arce</p>
        </footer>
      </div>
    </div>
    <!-- Script de utilidades AJAX, manejo de ids, base64 -->
    <script src="js/utils.js"></script>
    <!-- Script principal, de esta view -->
    <script src="js/main.js"></script>
  </body>
</html>