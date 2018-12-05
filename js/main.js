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
      <td><a href="editar-prod.php" data-id="#"><i class="material-icons">border_color</i></a></td>
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