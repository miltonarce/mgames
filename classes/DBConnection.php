<?php

/**
 * Clase DBConnection , maneja la conexión contra la base de datos, es Singleton
 * para no generar varias instancias de la conexión
 */
Class DBConnection
{
  private static $host  = "localhost";
  private static $user = "root";
  private static $pass = "";
  private static $base = "mgames";
  private static $db;

  private function __construct(){}

  public static function getConnection()
  {
    if (is_null(self::$db)) {
      $dsn="mysql:host=".self::$host.";dbname=".self::$base.";charset=utf8";
      try {
        self::$db = new PDO($dsn, self::$user, self::$pass);
      } catch(Exception $e) {
        die("Hubo un error de conexion a la base de datos. Por favor intente más tarde.");
      }
    }
    return self::$db;
  }
  
}