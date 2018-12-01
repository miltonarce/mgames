<?php

class Usuario
{
  public $id;
  public $usuario;
  public $password;

  public function getUser($usuario)
  {
    $db = DBConnection::getConnection();
    $query = "SELECT id, username, password FROM usuarios
    WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$usuario]);
    if($fila = $stmt->fetch()){
      $this->cargarDatosDeArray($fila);
      return true;
    }else{
      return false;
    }
  }

  public function cargarDatosDeArray($fila)
	{
		$this->id 		= $fila['id'];
		$this->usuario  = $fila['username'];
		$this->password = $fila['password'];
	}
}