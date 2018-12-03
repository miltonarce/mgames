<?php

/**
 * Clase para manipular la sesión de PHP, se hace un Wrapper...
 */
class Session
{   
    
    /**
     * Permite setear una key en la sesión
     * @param $key
     * @param $value
     * @return void
     */
    public static function set($key, $value) 
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Permite obtener una key de la sesión
     * @return Object
     */
    public static function get($key)
    {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Permite eliminar varias keys de la sesión
     * @param $keys
     * @return void
     */
    public static function remove($keys) 
    {
        foreach ($keys as $key) {
            unset($_SESSION[$key]);
        }
    }

}