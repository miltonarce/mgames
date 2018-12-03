<?php

/**
 * Clase Tipos que se encarga de representar el modelo de la tabla Tipos
 * realiza las acciones basicas de CRUD
 */
class Tipos implements JsonSerializable, CRUD
{

  protected $idTipo;
  protected $tipo;
  
  /**
   * Permite obtener todos los tipos que existen
   * @return Tipos[]
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
   * Permite encontrar un tipo por el id del mismo, si no existe el id lanza una excepción
   * @param $id
   * @throws NoExisteException
   * @return Tipos
   */
  public function find($id) 
  {
    $db = DBConnection::getConnection();
    $query = "SELECT * FROM tipos WHERE idtipo = ?";
    $stmt = $db->prepare($query);
    $stmt->execute([$id]);
    $fila = $stmt->fetch();
    if (!$fila) {
      throw new NoExisteException("No existe ningún registro con el id $id");
    }
    $tip = new Tipos;
    $tip->setIdTipo($fila['idtipo']);
    $tip->setTipo($fila['tipo']);
    return $tip;
  }

  /**
   * Permite eliminar un tipo por el id del mismo
   * @param $id
   * @throws NoExisteException
   * @return boolean
   */
  public function remove($id) 
  {
    $db = DBConnection::getConnection();
    $this->find($id); //Valido primero si existe el registro a eliminar...
    $query = "DELETE FROM tipos WHERE idtipo = ?";
    $stmt = $db->prepare($query);
    $status = $stmt->execute([$id]);
    return $stmt->rowCount();
  }

  /**
   * Permite crear un tipo , si se creó correctamente devuelve el id del tipo creado...
   * creado, sino devuelve null
   * @param $data
   * @return number|null
   */
  public function save($data) 
  {
    $db = DBConnection::getConnection();
    $query = "INSERT INTO tipos (tipo) VALUES (?)";
    $stmt = $db->prepare($query);
    $success = $stmt->execute([$data['tipo']]);
    if ($success) {
      return $db->lastInsertId();
    }
    return null;
  }

  /**
   * Permite editar un tipo por el id del mismo, 
   * actualiza la información del tipo con la data recibida
   * @param $id
   * @param $data
   * @return boolean
   */
  public function update($id, $data) 
  {
    $db = DBConnection::getConnection();
    $query = "UPDATE tipos SET idtipo= :idtipo, tipo= :tipo WHERE idtipo= :idtipo";
    $stmt = $db->prepare($query);
    $stmt->execute([
      'idtipo' => $id,
      'tipo' => $data['tipo'],
    ]);
    return $stmt->rowCount();
  }

  /**
	 * Implementación para serealizar el object y enviarse en JSON...
	 * @return {Object}
	 */
  public function jsonSerialize() 
  {
    return [
        'idTipo'=> $this->getIdTipo(),
        'tipo' => $this->getTipo()
      ];
  }
  
  //Getters y Setters
  public function setIdTipo($idTipo) 
  {
    $this->idTipo = $idTipo;
  }

  public function getIdTipo() 
  {
    return $this->idTipo;
  }

  public function setTipo($tipo) 
  {
    $this->tipo = $tipo;
  }

  public function getTipo() 
  {
    return $this->tipo;
  }

}