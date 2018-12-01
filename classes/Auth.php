<?php
  class Auth
  {

    /**
     * Permite autenticar al usuario, valida el password, hace un hash
     * para validarlo
     * @param $usuario
     * @param $password
     * @returns boolean
     */
    public function login ($usuario, $password)
    {
      $user = new Usuario;
      if ($user->getUser($usuario)) {
        if (password_verify($password, $user->password)) {
          $this->loginUser($user);
          return true;
        }
        return false;
      }
      return false;
    }
    
    public function loginUser(Usuario $user)
    {
      
      $_SESSION['id'] = $user->id;
      $_SESSION['username'] = $user->usuario;
    }

    /**
     * Permite cerrar la sesión del usuario
     * eliminando las variables de la sesión
     * @returns void
     */
    public function logout()
    {
      unset($_SESSION['id']);
      unset($_SESSION['username']);
    }

    /**
     * Permite verificar si el usuario esta logueado
     * @returns boolean
     */
    public static function isLogged()
    {
      return isset($_SESSION['id']);
    }

  }