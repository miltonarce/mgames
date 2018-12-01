<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/styles.css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <title>Millennial Games - Login</title>
</head>
<body>
  <main class="container">
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
				<label for="username">Usuario</label>
				<input type="text" name="username" id="username" class="form-control" value="<?php
				if(isset($_SESSION['old-input']) && isset($_SESSION['old-input']['username'])) {
					echo $_SESSION['old-input']['username'];
					unset($_SESSION['old-input']['username']);
				}
				?>">
			</div>
			<div class="form-group">
				<label for="password">Contraseña</label>
				<input type="password" name="password" id="password" class="form-control">
			</div>
			<button class="btn btn-primary btn-block">Ingresar</button>
		</form>
	</main>
</body>
</html>