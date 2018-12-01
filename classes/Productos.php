<?php

class Productos 
{
  protected $propiedades = ['idproducto', 'nombre', 'descripcion', 'stock', 'precio', 'fecha_alta', 'img', 'fkidcat', 'fkidtipo'];

 public function getProductos()
 {
   $db = DBConnection::getConnection();
   $query = "SELECT * FROM productos";
   $stmt = $db->prepare($query);
   $stmt->execute();
   $result = [];
   while($fila = $stmt->fetch()){
    $prod = new Productos;
    $prod->cargarDatosDeArray($fila);
    $salida[] = $prod;
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