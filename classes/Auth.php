<?php

  /**
   * Clase Auth que maneja la autenticación del usuario, si esta logueado,
   * realiza login, guarda en sesión los datos necesarios...
   */
  class Auth
  {

    /**
     * Permite autenticar al usuario, valida el password, hace un hash
     * para validarlo
     * @param $usuario
     * @param $password
     * @return boolean
     */
    public function login($usuario, $password)
    {
      $user = new Usuario;
      if ($user->getUser($usuario)) {
        if (password_verify($password, $user->getPassword())) {
          Session::set('USER_LOGGED_IN', serialize($user));
          return true;
        }
        return false;
      }
      return false;
    }

    /**
     * Permite cerrar la sesión del usuario
     * eliminando las variables de la sesión
     * @return void
     */
    public function logout()
    {
      Session::remove(['USER_LOGGED_IN']);
    }

    /**
     * Permite verificar si el usuario esta logueado
     * @return boolean
     */
    public static function isLogged()
    {
      return Session::get('USER_LOGGED_IN') ? true : false;
    }

    /**
     * Permite verificar si el usuario logueado es un ADMIN
     * @return boolean
     */
    public static function isAdmin() 
    {
      $user = Session::get('USER_LOGGED_IN');
      return $user->getIsAdmin();
    }

  }