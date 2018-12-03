<?php
require 'autoload.php';
if(!Auth::isLogged()) {
  header('Location: login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Millennial Games</title>
  <link rel="stylesheet" href="css/dist/css/bootstrap.css">
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
</head>
<body>
  <div class="container-main container-fluid">
      <header>
              <nav class="navbar navbar-light bg-light">
                <a href="index.php"><h1 class="logo">Millennial Games</h1></a>
                <ul class="nav justify-content-end">
                  <li class="nav-item">
                  <a class="nav-link" href="#"> Bienvenido! <span class="badge badge-light"><?= unserialize(Session::get('USER_LOGGED_IN'))->getUsuario() ?></span></a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                  </li>
                </ul>
              </nav>
      </header>
    <div class="d-flex justify-content-center">
      <div id="msg"></div>
      <main id="main-cont"> 
        <div class="container">
          <div class="row add">
            <div class="col">
              </div>
              <div class="col">
                   <a class="btn btn-primary btn-lg btn-block" href="agregar-prod.php" role="button">Agregar nuevo producto</a>
              </div>
              <div class="col">
              </div>
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
              <tbody id="items">    
                    
              </tbody>
            </table>
          </div>
        </div>
      </main>
      <footer class="footer d-flex justify-content-end">
      <p>Tp1 by Matias Torre - Milton Arce</p>
    </footer>
    </div>
  </div>

  <script src="js/ajax.js"></script>
  <script src="js/main.js"></script>
</body>
</html>