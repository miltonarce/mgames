window.addEventListener('DOMContentLoaded', () => {
  recargarItems();
});

/**
 * Permite obtener todos los productos mediante AJAX llamando al service
 * del API /productos
 * @return void
 */
const recargarItems = () => {
  ajax({
    method: 'GET',
    url: 'api/productos.php',
    successCallback: response => {
      $('items').innerHTML = generarTemplate(response);
      agregarDeleteEventListener();
      agregarEditEventListener();
    }
  });
}

/**
 * Permite crear el template de los productos a mostrar
 * en la tabla...
 * @param {Array<Object>} productos
 * @return string
 */
const generarTemplate = productos => {
  let template = '';
  productos.forEach(producto => {
    template += `<tr>
      <td>${producto.idproducto}</td>
      <td><img class="img-thumbnail" src="uploads/${producto.img}" alt="imagen de ${producto.nombre}" /></td>
      <td>${producto.nombre}</td>
      <td>${producto.descripcion}</td>
      <td>${producto.stock}</td>
      <td><strong class="badge badge-success">$ ${producto.precio}</strong></td>
      <td><strong class="badge badge-secondary">${producto.fecha_alta}</strong></td>
      <td>${producto.categoria.categoria}</td>
      <td>${producto.tipo.tipo}</td>
      <td><a href="#" data-id="${producto.idproducto}"><i class="material-icons">border_color</i></a></td>
      <td><a href="#" data-id-remove="${producto.idproducto}"><i class="material-icons">delete_forever</i></a></td>
    </tr>`
  });
  return template;
}

/**
 * Permite agregar a los botones de eliminar los event listener para
 * el click, al clickear el eliminar usa AJAX para realizar el delete
 * del producto
 * @return void
 */
const agregarDeleteEventListener = () => {
  let elements = document.querySelectorAll('a[data-id-remove]');
  elements.forEach(element => {
    element.addEventListener('click', el => {
      let idProducto = element.dataset['idRemove'];
      ajax({
        method: 'DELETE',
        url: `api/productos.php?id=${idProducto}`,
        successCallback: response => {
          crearAlert('alert-success', response.msg);
          recargarItems();
        }
      });
    });
  });
}

/**
 * Función que agrega el evento de editar
 */
const agregarEditEventListener = () => {
  let elements = document.querySelectorAll('a[data-id]');
  elements.forEach(element => {
    element.addEventListener('click', el => {
      let idProducto = element.dataset['id'];
      ajax({
        url: 'api/productos.php',
        data: 'id=' + idProducto,
        successCallback: response => {
          console.log(response);
          let { idproducto, nombre, descripcion, stock, precio, categoria, tipo, img } = response;
          document.getElementById('main-cont').innerHTML = ` <div  class="main-content container bg-light"> <h2>Editar Producto</h2>
          <p>Módifique los datos del producto que desea editar.</p>
          <form action="editar.php" id="editarprod" method="post" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" name="nombre" id="nombre" value="${nombre}" class="form-control">
              </div>
              <div class="form-group">
                  <label for="genero">Descripción</label>
                  <textarea name="descripcion" id="descripcion"  class="form-control">${descripcion}</textarea>
              </div>
              <div class="form-group">
                  <label for="genero">Stock</label>
                  <input type="text" name="stock" id="stock" value="${stock}"  class="form-control">
              </div>
              <div class="form-group">
                  <label for="precio">Precio</label>
                  <input type="text" name="precio" id="precio" value="${precio}"   class="form-control">
              </div>
              <div class="form-group">
                  <label for="fecha">Categoría</label>
                  <select class="custom-select" name="categoria" id="categoria">
  
                  </select>
              </div>
              <div class="form-group">
                  <label for="descripcion">Producto</label>
                  <select class="custom-select" name="producto" id="producto">
                  </select>
                  
                </div>
              <div class="form-group">
                  <label for="descripcion">Imagen</label>
                  <input type="file" name="imagen" id="imagen" class="form-control" />
                  <div id="getIMG"><img class="img-thumbnail" src="uploads/${img}" alt="imagen de ${nombre}" /></div>
              </div>
              <button class="btn btn-primary btn-block">Editar producto</button>
          </form></div>`
          getAllCategorias(idproducto, categoria.idcat);
          getAllTipos(idproducto, tipo.idTipo);
        }
      })
    });
  });
}
