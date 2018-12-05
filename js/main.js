window.addEventListener('DOMContentLoaded', () => {
  recargarItems();
});

const recargarItems = () => {
  ajax({
    method: 'GET',
    url: 'api/productos.php',
    successCallback: response => {
      let productos = JSON.parse(response);
      document.getElementById('items').innerHTML = generarTemplate(productos);
      agregarDeleteEventListener();
      agregarEditEventListener();
    }
  });
}

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
 * Función que agrega el evento de borrar
 */
const agregarDeleteEventListener = () => {
  let elements = document.querySelectorAll('a[data-id-remove]');
  elements.forEach(element => {
    element.addEventListener('click', el => {
      let idProducto = element.dataset['idRemove'];
      ajax({
        method: 'DELETE',
        url: `api/productos.php?id=${idProducto}`,
        successCallback: rta => {
          let response = JSON.parse(rta);
          document.getElementById('msg').innerHTML = `<div class="mg-alert alert alert-success alert-dismissible fade show" role="alert">
           ${response.msg}
           <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
           </button>
         </div>`
          recargarItems();
          dismiss();
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
        successCallback: rta => {
          let response = JSON.parse(rta);
          let { nombre, descripcion, stock, precio, categoria, producto, img } = response;
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
                  <div id="getIMG"></div>
              </div>
              <button class="btn btn-primary btn-block">Agregar producto</button>
          </form></div>`
          recargarCategorias();
          recargarTipo();
        }
      })
    });
  });
}

/**
 * Function para cerrar popups
 */
const dismiss = () => {
  let alert = document.querySelectorAll('button[data-dismiss]');
  alert.forEach(al => {
    al.addEventListener('click', a => {
      a.parentNode.removeChild(a);
    });
  });
}