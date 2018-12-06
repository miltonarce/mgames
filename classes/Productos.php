<?php

   /**
   * Clase Productos que se encarga de representar el modelo de la tabla Productos
   * realiza las acciones basicas de CRUD
   */
  class Productos implements JsonSerializable, CRUD
  {

    protected $idproducto;
    protected $nombre;
    protected $descripcion;
    protected $stock;
    protected $precio;
    protected $fecha_alta;
    protected $img;
    protected $categoria;
    protected $tipo;

    /**
     * Permite obtener todos los productos que existen...
     * @return Productos[]
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
        $prod = $this->populateProducto($fila);
        $productos[] = $prod;
      }
      return $productos;
    }

    /**
     * Permite obtener un producto por el id del mismo, si no existe el id lanza una excepción
     * @param $id
     * @throws NoExisteException
     * @return Productos
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
      if (!$fila) {
        throw new NoExisteException("No existe ningún registro con el id $id");
      }
      return $this->populateProducto($fila);
    }

    /**
     * Permite eliminar un producto por el id del mismo
     * @param $id
     * @throws NoExisteException
     * @return boolean
     */
    public function remove($id) 
    {
      $db = DBConnection::getConnection();
      $this->find($id); //Valido primero si existe el registro a eliminar...
      $query = "DELETE FROM productos WHERE idproducto = ?";
      $stmt = $db->prepare($query);
      $status = $stmt->execute([$id]);
      return $stmt->rowCount();
    }

    /**
     * Permite crear un producto , si se creó correctamente devuelve el id del producto creado...
     * creado, sino devuelve null
     * @param $data
     * @return number|null
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
          'img' =>  isset($data['img']) ? $this->saveImage($data['img']) : 'no-image.png',
          'fkidcat' => $data['fkidcat'],
          'fkidtipo' => $data['fkidtipo']
      ]);
      if ($success) {
        return $db->lastInsertId();
      }
      return null;
    }

    /**
     * Permite editar un producto por el id del mismo, 
     * actualiza la información del producto con la data recibida
     * @param $id
     * @param $data
     * @throws NoExisteException
     * @return boolean
     */
    public function update($id, $data)
    {
      $db = DBConnection::getConnection();
      $productToEdit = $this->find($id); //Valido primero si existe el registro a editar...
      $query = "UPDATE productos SET 
                      nombre = :nombre, 
                      descripcion = :descripcion, 
                      stock = :stock,
                      precio =  :precio,
                      img = :img,
                      fkidcat = :fkidcat,
                      fkidtipo = :fkidtipo
                      WHERE idproducto = :idproducto";
      $stmt = $db->prepare($query);
      $status = $stmt->execute([
        'nombre' => $data['nombre'],
        'descripcion' => $data['descripcion'],
        'stock' => $data['stock'],
        'precio' => $data['precio'],
        'img' => isset($data['img']) ? $this->saveImage($data['img']) : $productToEdit->getImg(),
        'fkidcat' => $data['fkidcat'],
        'fkidtipo' => $data['fkidtipo'],
        'idproducto' => $id
      ]);
      return $stmt->rowCount();
    }

    /**
     * Permite filtar los productos por una descripción ingresada
     * @param $search
     * @return Productos[]
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
        $prod = $this->populateProducto($fila);
        $productos[] = $prod;
      }
      return $productos;
    }

    /**
     * Implementación para serealizar el object y enviarse en JSON...
     * @return Object
     */
    public function jsonSerialize() 
    {
      return [
        'idproducto'=> $this->getIdProducto(),
        'nombre' => $this->getNombre(),
        'descripcion' => $this->getDescripcion(),
        'stock' => $this->getStock(),
        'precio' => $this->getPrecio(),
        'fecha_alta' => $this->getFechaAlta(),
        'img' => $this->getImg(),
        'categoria' => $this->getCategoria(),
        'tipo' => $this->getTipo()
      ];
    }

    /**
     * Permite crear un Producto con los datos recibidos de la fila,
     * genera el object usando los setters y carga la categoria y el tipo...
     * @param $row
     * @return Productos
     */
    private function populateProducto($row) 
    {
      //Categoria
      $cat = new Categorias;
      $cat->setIdCat($row['idcat']);
      $cat->setCategoria($row['categoria']);
      //Tipo
      $tipo = new Tipos;
      $tipo->setIdTipo($row['idtipo']);
      $tipo->setTipo($row['tipo']);
      //Producto
      $prod = new Productos;
      $prod->setIdProducto($row['idproducto']);
      $prod->setNombre($row['nombre']);
      $prod->setDescripcion($row['descripcion']);
      $prod->setFechaAlta($row['fecha_alta']);
      $prod->setStock($row['stock']);
      $prod->setPrecio($row['precio']);
      $prod->setImg($row['img']);
      $prod->setCategoria($cat);
      $prod->setTipo($tipo);
      return $prod;
    }

    /**
     * Permite guardar la imagen en disco, en la carpeta uploads, retorna el nombre de la imagen...
     * @param $img
     * @return string
     */
    private function saveImage($base64) {
      $data = explode(',', $base64);
      $extension = '.png';
      $extData = explode('/', $data[0]);
      if(strpos($extData[1], 'jpeg') !== false) {
          $extension = '.jpg';
      }
      $imageData = base64_decode($data[1]);
      $imageName = time() . $extension;
      file_put_contents('../uploads/' . $imageName, $imageData);
      return $imageName;
    }

    //Getters y Setters
    public function setIdProducto($idproducto) 
    {
      $this->idproducto = $idproducto;
    }

    public function getIdProducto() 
    {
      return $this->idproducto;
    }

    public function setNombre($nombre) 
    {
      $this->nombre = $nombre;
    }

    public function getNombre() 
    {
      return $this->nombre;
    }

    public function setDescripcion($descripcion) 
    {
      $this->descripcion = $descripcion;
    }

    public function getDescripcion() 
    {
      return $this->descripcion;
    }

    public function setStock($stock) 
    {
      $this->stock = $stock;
    }

    public function getStock() 
    {
      return $this->stock;
    }

    public function setPrecio($precio) 
    {
      $this->precio = $precio;
    }

    public function getPrecio() 
    {
      return $this->precio;
    }

    public function setFechaAlta($fecha_alta) 
    {
      $this->fecha_alta = $fecha_alta;
    }

    public function getFechaAlta() 
    {
      return $this->fecha_alta;
    }

    public function setImg($img) 
    {
      $this->img = $img;
    }

    public function getImg() 
    {
      return $this->img;
    }

    public function setCategoria(Categorias $categoria) 
    {
      $this->categoria = $categoria;
    }

    public function getCategoria() 
    {
      return $this->categoria;
    }

    public function setTipo(Tipos $tipo) 
    {
      $this->tipo = $tipo;
    }

    public function getTipo() 
    {
      return $this->tipo;
    }

}