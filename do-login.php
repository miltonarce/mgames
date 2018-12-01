<?php
require 'autoload.php';
$auth = new Auth;
if($auth->login($_POST['username'], $_POST['password'])) {
	header('Location: index.php');
} else {
	$_SESSION['error'] = "Usuario o contraseña invalidos, intente nuevamente.";
	$_SESSION['old-input'] = $_POST;
	header('Location: login.php');
}