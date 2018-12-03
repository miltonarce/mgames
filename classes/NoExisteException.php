<?php

/**
 * Clase NoExisteException, esta excepción se utiliza cuando no existe
 * el item que se esta buscando por un id...
 */
class NoExisteException extends Exception
{

    public function __construct($message, $code = 0) 
    {
        parent::__construct($message, $code);
    }

    public function __toString() 
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }

}