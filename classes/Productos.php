<?php

  /**
   * Model para tabla Productos
   * 
   * Métodos
   *  getProductos
   *  getProductoById
   *  deleteById
   *  edit
   *  filter
   *  create
   *  cargarDatosDeArray
   */
  class Productos 
  {
    protected $propiedades = ['idproducto', 'nombre', 'descripcion', 'stock', 'precio', 'fecha_alta', 'img', 'fkidcat', 'fkidtipo'];

    /**
     * Permite obtener todos los productos que existen...
     * @returns $productos[]
     */
    public function all()
    {
      $db = DBConnection::getConnection();
      $query = "SELECT * FROM productos p 
                    INNER JOIN CATEGORIAS c ON c.idcat = p.fkidcat
                    INNER JOIN TIPOS t ON t.idtipo = p.fkidtipo";
      $stmt = $db->prepare($query);
      $stmt->execute();
      $productos = [];
      while($fila = $stmt->fetch()){
        $prod = new Productos;
        $prod->cargarDatosDeArray($fila);
        $productos[] = $prod;
      }
      return $productos;
    }

    /**
     * Permite obtener un producto por el id del mismo
     * @param $id
     * @return Producto
     */
    public function find($id) 
    {
      $db = DBConnection::getConnection();
      $query = "SELECT * FROM productos p 
                    INNER JOIN CATEGORIAS c ON c.idcat = p.fkidcat
                    INNER JOIN TIPOS t ON t.idtipo = p.fkidtipo
                    WHERE p.idproducto = ?";
      $stmt = $db->prepare($query);
      $stmt->execute([$id]);
      $fila = $stmt->fetch();
      $prod = new Productos;
      $prod->cargarDatosDeArray($fila);
      return $prod;
    }

    /**
     * Permite eliminar un producto por el id del mismo
     * @param $id
     * @returns boolean
     */
    public function remove($id) 
    {
      $db = DBConnection::getConnection();
      $query = "DELETE FROM productos WHERE idproducto = ?";
      $stmt = $db->prepare($query);
      $status = $stmt->execute([$id]);
      return $stmt->rowCount();
    }

    /**
     * Permite editar un producto por el id del mismo, 
     * actualiza la información del producto con la data recibida
     * @param $id
     * @param $data
     * @returns boolean
     */
    public function update($id, $data)
    {
      $db = DBConnection::getConnection();
      $query = "UPDATE productos SET 
                      nombre = :nombre, 
                      descripcion = :descripcion, 
                      stock = :stock,
                      precio =  :precio,
                      img = :img,
                      fkidcat = :fkidcat,
                      fkidtipo = ':fkidtipo
                      WHERE idproducto = :idproducto";
      $stmt = $db->prepare($query);
      $status = $stmt->execute([
        'nombre' => $data['nombre'],
        'descripcion' => $data['descripcion'],
        'stock' => $data['stock'],
        'precio' => $data['precio'],
        'img' => $data['img'],
        'fkidcat' => $data['fkidcat'],
        'fkidtipo' => $data['fkidtipo'],
        'idproducto' => $id
      ]);
      return $stmt->rowCount();
    }

    /**
     * Permite filtar los productos por una descripción ingresada
     * @param $search
     * @returns $productos[]
     */
    public function filter($search) 
    {
      $db = DBConnection::getConnection();
      $query = "SELECT * FROM productos p 
                    INNER JOIN CATEGORIAS c ON c.idcat = p.fkidcat
                    INNER JOIN TIPOS t ON t.idtipo = p.fkidtipo
                    WHERE p.descripcion LIKE ?";
      $stmt = $db->prepare($query);
      $stmt->execute(["%$search%"]);
      $productos = [];
      while($fila = $stmt->fetch()){
        $prod = new Productos;
        $prod->cargarDatosDeArray($fila);
        $productos[] = $prod;
      }
      return $productos;
    }

     /**
     * Permite crear un producto , si se creó correctamente devuelve el object con el id
     * creado, sino devuelve null
     * @param $data
     * @returns Producto | null
     */
    public function save($data) 
    {
      $db = DBConnection::getConnection();
      $query = "INSERT INTO productos (nombre, descripcion, stock, precio, fecha_alta, img, fkidcat, fkidtipo)
              VALUES (:nombre, :descripcion, :stock, :precio, NOW(), :img, :fkidcat, :fkidtipo)";
      $stmt = $db->prepare($query);
      $success = $stmt->execute([
          'nombre' => $data['nombre'],
          'descripcion' => $data['descripcion'],
          'stock' => $data['stock'],
          'precio' => $data['precio'],
          'img' =>  isset($data['img']) ? $data['img'] : 'uploads/no-image.png',
          'fkidcat' => $data['fkidcat'],
          'fkidtipo' => $data['fkidtipo']
      ]);
      if ($success) {
        $data['idproducto'] = $db->lastInsertId();
        $prod = new Productos;
        $prod->cargarDatosDeArray($data);
        return $prod;
      }
      return null;
    }

    /**
     * Permite cargar todos los datos al object para poder
     * devolverlos en la respuesta...
     * @param $fila
     * @returns void
     */
    private function cargarDatosDeArray($fila)
    {
      foreach($this->propiedades as $prop){
        $this->{$prop} = $fila[$prop];
      }
    }

}