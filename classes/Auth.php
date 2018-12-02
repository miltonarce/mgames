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
     * @returns boolean
     */
    public function login($usuario, $password)
    {
      $user = new Usuario;
      if ($user->getUser($usuario)) {
        if (password_verify($password, $user->getPassword())) {
          Session::set('id', $user->getId());
          Session::set('username', $user->getUsuario());
          return true;
        }
        return false;
      }
      return false;
    }

    /**
     * Permite cerrar la sesión del usuario
     * eliminando las variables de la sesión
     * @returns void
     */
    public function logout()
    {
      Session::remove('id');
      Session::remove('username');
    }

    /**
     * Permite verificar si el usuario esta logueado
     * @returns boolean
     */
    public static function isLogged()
    {
      return Session::get('id') ? true : false;
    }

  }