<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/dist/css/bootstrap.css">
  <link rel="stylesheet" href="css/login.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <title>Millennial Games - Login</title>
</head>
<body>
	<div id="content">
		<main class="container" id="content-login">
			<h1>Iniciar Sesión</h1>
			<?php
				if(isset($_SESSION['error'])) {
			?>
				<div class="alert alert-danger"><?= $_SESSION['error'];?></div>
			<?php
				unset($_SESSION['error']);
			}
			?>

			<form action="do-login.php" method="POST">
				<div class="form-group">
				<label for="exampleInputEmail1" >Usuario</label>
					<input type="text" name="username" id="username" class="mg-input-text form-control" value="<?php
					if(isset($_SESSION['old-input']) && isset($_SESSION['old-input']['username'])) {
						echo $_SESSION['old-input']['username'];
						unset($_SESSION['old-input']['username']);
					}
					?>">
				</div>
				<div class="form-group">
				<label for="exampleInputEmail1">Contraseña</label>
					<input type="password" name="password" id="password" class="mg-input-text form-control">
				</div>
				<button class="btn btn-primary btn-block">Ingresar</button>
			</form>
		</main>
	</div>
</body>
</html>