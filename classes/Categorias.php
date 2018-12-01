<?php

  class Categorias
  {
    protected $propiedades = ['idcat', 'categoria'];

    /**
     * Permite obtener todas las categorias disponibles
     * @returns Categorias[]
     */
    public function getCategorias()
    {
      $db = DBConnection::getConnection();
      $query = "SELECT * FROM categorias";
      $stmt = $db->prepare($query);
      $stmt->execute();
      $result = [];
      while($fila = $stmt->fetch()){
        $cat = new Categorias;
        $cat->cargarDatosDeArray($fila);
        $salida[] = $cat;
      }
      return $salida;
    }
    
    private function cargarDatosDeArray($fila)
    {
      foreach($this->propiedades as $prop){
        $this->{$prop} = $fila[$prop];
      }
    }
  }