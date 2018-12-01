<?php

class Tipos implements JsonSerializable
{

  protected $idTipo;
  protected $tipo;
  
  /**
   * Permite obtener todos los tipos disponbiles
   * @returns Tipos[]
   */
  public function all()
  {
    $db = DBConnection::getConnection();
    $query = "SELECT * FROM tipos";
    $stmt = $db->prepare($query);
    $stmt->execute();
    $result = [];
    while($fila = $stmt->fetch()){
      $tip = new Tipos;
      $tip->setIdTipo($fila['idtipo']);
      $tip->setTipo($fila['tipo']);
      $salida[] = $tip;
    }
    return $salida;
  }
  
  /**
	 * Implementación para serealizar el object y enviarse en JSON...
	 * @return {Object}
	 */
  public function jsonSerialize() {
    return [
        'idTipo'=> $this->getIdTipo(),
        'tipo' => $this->getTipo()
      ];
  }
  
  //Getters y Setters
  public function setIdTipo($idTipo) {
    $this->idTipo = $idTipo;
  }

  public function getIdTipo() {
    return $this->idTipo;
  }

  public function setTipo($tipo) {
    $this->tipo = $tipo;
  }

  public function getTipo() {
    return $this->tipo;
  }

}