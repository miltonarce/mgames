<?php

class Tipos
{

  protected $propiedades = ['idtipo', 'tipo'];

  /**
   * Permite obtener todos los tipos disponbiles
   * @returns Tipos[]
   */
  public function getTipos()
  {
    $db = DBConnection::getConnection();
    $query = "SELECT * FROM tipos";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = [];
    while($fila = $stmt->fetch()){
      $tip = new Tipos;
      $tip->cargarDatosDeArray($fila);
      $salida[] = $tip;
    }
    return $salida;
  }
  
  public function cargarDatosDeArray($fila)
  {
    foreach($this->propiedades as $prop){
      $this->{$prop} = $fila[$prop];
    }
  }
}