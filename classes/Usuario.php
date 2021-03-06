<?php

/**
 * Clase Usuario que se encarga de representar el modelo de la tabla Usuario
 */
class Usuario
{

  protected $id;
  protected $usuario;
  protected $password;
  protected $isAdmin;

  /**
   * Permite obtener el usuario por el username...
   * @param $username
   * @return boolean
   */
  public function getUser($usuario)
  {
    $db = DBConnection::getConnection();
    $query = "SELECT id, username, password FROM usuarios WHERE username = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$usuario]);
    if ($fila = $stmt->fetch()) {
      $this->setId($fila['id']);
      $this->setUsuario($fila['username']);
      $this->setPassword($fila['password']);
      return true;
    }
    return false;
  }

  //Getters y Setters
  public function setId($id) 
  {
    $this->id = $id;
  }

  public function getId() 
  {
    return $this->id;
  }

  public function setUsuario($usuario) 
  {
    $this->usuario = $usuario;
  }

  public function getUsuario() 
  {
    return $this->usuario;
  }

  public function setPassword($password) 
  {
    $this->password = $password;
  }

  public function getPassword() 
  {
    return $this->password;
  }

  public function setIsAdmin($isAdmin) 
  {
		$this->isAdmin = $isAdmin;
	}

  public function getIsAdmin() 
  {
		return $this->isAdmin;
	}

}