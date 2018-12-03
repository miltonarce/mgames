<?php

  /**
   * Clase Categorías que se encarga de representar el modelo de la tabla Categorías
   * realiza las acciones basicas de CRUD
   */
  class Categorias implements JsonSerializable, CRUD
  {

    protected $idcat;
    protected $categoria;

    /**
     * Permite obtener todas las categorías disponibles
     * @return Categorias[]
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
     * Permite obtener una categoría especifica por el id, si el id es inválido lanza una excepción...
     * @param $id
     * @throws NoExisteException
     * @return Categorias
     */
    public function find($id) 
    {
      $db = DBConnection::getConnection();
      $query = "SELECT * FROM categorias WHERE idcat = ?";
      $stmt = $db->prepare($query);
      $stmt->execute([$id]);
      $fila = $stmt->fetch();
      if (!$fila) {
        throw new NoExisteException("No existe ningún registro con el id $id");
      }
      $cat = new Categorias;
      $cat->setIdCat($fila['idcat']);
      $cat->setCategoria($fila['categoria']);
      return $cat;
    }

    /**
     * Permite eliminar una categoria por el id
     * @param $id
     * @throws NoExisteException
     * @return boolean 
     */
    public function remove($id) 
    {
      $db = DBConnection::getConnection();
      $this->find($id); //Valido primero si existe el registro a eliminar...
      $query = "DELETE FROM categorias WHERE idcat = ?";
      $stmt = $db->prepare($query);
      $status = $stmt->execute([$id]);
      return $stmt->rowCount();
    }

    /**
     * Permite dar de alta a una categoría, devuelve el id del registro creado...
     * @param $data
     * @return number
     */
    public function save($data) 
    {
      $db = DBConnection::getConnection();
      $query = "INSERT INTO categorias (categoria) VALUES (?)";
      $stmt = $db->prepare($query);
      $success = $stmt->execute([$data['categoria']]);
      if ($success) {
        return $db->lastInsertId();
      }
      return null;
    }

    /**
     * Permite actualizar una categoría
     * @param $id
     * @param $data
     * @return boolean
     */
    public function update($id, $data) 
    {
      $db = DBConnection::getConnection();
      $query = "UPDATE categorias SET idcat= :idcat, categoria= :categoria WHERE idcat= :idcat";
      $stmt = $db->prepare($query);
      $stmt->execute([
        'idcat' => $id,
        'categoria' => $data['categoria'],
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
        'idcat'=> $this->getIdCat(),
        'categoria' => $this->getCategoria(),
      ];
    }
    
    //Getters y Setters
    public function setIdCat($idcat) 
    {
      $this->idcat = $idcat;
    }

    public function getIdCat() 
    {
      return $this->idcat;
    }

    public function setCategoria($categoria) 
    {
      $this->categoria = $categoria;
    }

    public function getCategoria() 
    {
      return $this->categoria;
    }

}