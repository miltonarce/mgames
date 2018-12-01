<?php

  class Categorias implements JsonSerializable
  {

    protected $idcat;
    protected $categoria;

    /**
     * Permite obtener todas las categorias disponibles
     * @returns Categorias[]
     */
    public function all()
    {
      $db = DBConnection::getConnection();
      $query = "SELECT * FROM categorias";
      $stmt = $db->prepare($query);
      $stmt->execute();
      $result = [];
      while($fila = $stmt->fetch()){
        $cat = new Categorias;
        $cat->setIdCat($fila['idcat']);
        $cat->setCategoria($fila['categoria']);
        $salida[] = $cat;
      }
      return $salida;
    }

    /**
     * Implementación para serealizar el object y enviarse en JSON...
     * @return {Object}
     */
    public function jsonSerialize() {
      return [
        'idcat'=> $this->getIdCat(),
        'categoria' => $this->getCategoria(),
      ];
    }
    
    //Getters y Setters
    public function setIdCat($idcat) {
      $this->idcat = $idcat;
    }

    public function getIdCat() {
      return $this->idcat;
    }

    public function setCategoria($categoria) {
      $this->categoria = $categoria;
    }

    public function getCategoria() {
      return $this->categoria;
    }

}