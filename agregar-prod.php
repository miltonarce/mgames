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
                <main class="main-content container bg-light">
                    <h2>Agregar Producto</h2>
                    <p>Ingrese los datos del producto que desea agregar.</p>
                    <form action="agregar.php" id="agregarprod" method="post">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="genero">Descripción</label>
                            <textarea name="descripcion" id="descripcion" placeholder="mínimo 3 caracteres" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="genero">Stock</label>
                            <input type="text" name="stock" id="stock" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="precio">Precio</label>
                            <input type="text" name="precio" id="precio" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="fecha">Categoría</label>
                            <select class="custom-select" name="categoria" id="categoria"></select>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Producto</label>
                            <select class="custom-select" name="producto" id="producto"></select>
                        </div>
                        <div class="form-group">
                            <label for="descripcion">Imagen</label>
                            <input type="file" name="img" id="img" class="form-control" />
                        </div>
                        <button class="btn btn-primary btn-block">Agregar producto</button>
                        <div id="errores" style="margin:1em"></div>
                    </form>
                </main>
            </div>
            <footer class="footer d-flex justify-content-end">
                <p>Tp1 by Matias Torre - Milton Arce</p>
            </footer>
        </div>
        <!-- Script de utilidades AJAX, manejo de ids, base64 -->
        <script src="js/utils.js"></script>
        <!-- Script principal, de esta view -->
        <script src="js/agregar-prod.js"></script>
    </body>
</html>