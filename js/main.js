window.addEventListener('DOMContentLoaded', () => {
  recargarItems();
  addEventListenerLogout();
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
      $('items').innerHTML = crearRegistrosTablaProductos(response);
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
const crearRegistrosTablaProductos = productos => {
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
 * Permite agregar el evento click de editar, a los productos,
 * llama al servicio de php para eliminarlos...
 * @return void
 */
const agregarEditEventListener = () => {
  let elements = document.querySelectorAll('a[data-id]');
  elements.forEach(element => {
    element.addEventListener('click', el => {
      let idProducto = element.dataset['id'];
      ajax({
        url: 'api/productos.php',
        data: `id=${idProducto}`,
        successCallback: response => {
          $('main-cont').innerHTML = crearTemplateFormularioEdit(response);
          getAllCategorias(idProducto, response.categoria.idcat);
          getAllTipos(idProducto, response.tipo.idTipo);
          addSubmitEventFormEditProduct(idProducto);
        }
      })
    });
  });
}

/**
 * Permite crear el template del formulario de edición con los datos cargados
 * obtenidos del ajax
 * @param {Object} response
 * @return {string}
 */
const crearTemplateFormularioEdit = response => {
  let { idproducto, nombre, descripcion, stock, precio, categoria, tipo, img } = response;
  return `
  <div class="main-content container bg-light"> 
    <h2>Editar Producto</h2>
    <p>Módifique los datos del producto que desea editar.</p>
    <form action="editar.php" id="editarprod" method="post">
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
        <input type="text" name="stock" id="stock" value="${stock}" class="form-control">
      </div>
      <div class="form-group">
        <label for="precio">Precio</label>
        <input type="text" name="precio" id="precio" value="${precio}" class="form-control">
      </div>
      <div class="form-group">
        <label for="fecha">Categoría</label>
        <select class="custom-select" name="categoria" id="categoria"></select>
      </div>
      <div class="form-group">
        <label for="descripcion">Producto</label>
        <select class="custom-select" name="producto" id="producto"></select>
      </div>
      <div class="form-group">
        <label for="descripcion">Imagen</label>
        <input type="file" name="img" id="img" class="form-control" />
        <div id="getIMG"><img class="img-thumbnail" src="uploads/${img}" alt="imagen de ${nombre}" /></div>
      </div>
      <button class="btn btn-primary btn-block">Editar producto</button>
      <div id="errores" style="margin:1em"></div>
    </form>
  </div>`;
}

/**
 * Permite agregar al href del logout, el evento click
 * para que se desloguee el usuario llamando a la API /auth
 * @return void
 */
const addEventListenerLogout = () => {
  let logoutLink = $('logout');
  logoutLink.addEventListener('click', () => {
    ajax({
      method: 'GET',
      url: 'api/auth.php',
      successCallback: response => {
        if (response.status === 1) {
          window.location.href = 'login.php';
        }
      }
    });
  });
}

/**
 * Permite setear el evento submit del formulario para manejar la edición de un producto
 * @param {number} idprod
 * @return void
 */
const addSubmitEventFormEditProduct = (idprod) => {
	$('errores').innerHTML = '';
	$('errores').className = '';
	let formEditProd = $('editarprod');
	formEditProd.addEventListener('submit', ev => {
		ev.preventDefault();
		let errores = obtenerErrores(obtenerCampos());
		if (esValidoElForm(errores)) {
			crearRequest().then(request => {
				ajax({
					method: 'PUT',
					url: `api/productos.php?id=${idprod}`,
					data: request,
					successCallback: response => {
						crearAlert('alert-success', response.msg);
					}
				});
			});
		} else {
      $('errores').className = 'alert alert-warning';
      $('errores').innerHTML = `${errores.nombre} <br/> ${errores.descripcion} <br/> ${errores.precio} <br/> ${errores.stock} <br/>`;
    }
	});
}
