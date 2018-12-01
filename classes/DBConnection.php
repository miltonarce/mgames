<?php
/**
 * Conexión a mi DB por PDO
 */
Class DBConnection
{
  private static $host  = "localhost";
  private static $user = "root";
  private static $pass = "";
  private static $base = "arce_milton_millenialgames";
  private static $db;

  private function __construct(){}

  public static function getConnection(){
    if(is_null(self::$db)){
      $dsn="mysql:host=".self::$host.";dbname=".self::$base.";charset=utf8";

      try{
        self::$db = new PDO($dsn, self::$user, self::$pass);
      }catch(Exception $e){
        die("Hubo un error de conexion a la base de datos. Por favor intente más tarde.");
      }
    }
    return self::$db;
  }
}