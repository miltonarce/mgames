<?php

/**
 * Clase para manipular la sesión de PHP
 */
class Session
{   
    
    /**
     * Permite setear una key en la sesión
     * @param $key
     * @param $value
     * @returns void
     */
    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    /**
     * Permite obtener una key de la sesión
     * @returns $object
     */
    public function get($key) {
        return isset($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Permite eliminar varias keys de la sesión
     * @param $keys
     * @returns void
     */
    public function remove($keys) {
        foreach ($keys as $key) {
            unset($_SESSION[$key]);
        }
    }

}