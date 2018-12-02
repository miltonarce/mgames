<?php

/**
 * Interfaz para manejar las acciones básicas de un CRUD
 * all: Poder obtener todos los registros
 * find: Encontrar un registro por id
 * remove: Eliminar por id
 * update: Actualizar registro por id
 * save: Crear un nuevo registro
 */
interface CRUD
{
    public function all();
    public function find($id);
    public function remove($id);
    public function update($id, $data);
    public function save($data);
}