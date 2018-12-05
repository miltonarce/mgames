window.addEventListener('DOMContentLoaded', () => {
  getAllCategorias();
  getAllTipos();
  addSubmitEventFormAddProduct();
});

/**
 * Permite obtener todas las categorías disponibles que existen,
 * genera el html correspondiente, para popular el select...
 * @return void
 */
const getAllCategorias = () => {
  ajax({
    method: 'GET',
    url: 'api/categorias.php',
    successCallback: response => {
      let template = '';
      response.forEach(cat => {
        template += `<option value="${cat.idcat}">${cat.categoria}</option>`;
      });
      $('categoria').innerHTML = template;
    }
  });
}

/**
 * Permite obtener todos los tipos disponbiles que existen,
 * genera el html correspondiente, para popular el select...
 * @return void
 */
const getAllTipos = () => {
  ajax({
    method: 'GET',
    url: 'api/tipos.php',
    successCallback: response => {
      let template = '';
      response.forEach(function (type) {
        template += `<option value="${type.idTipo}">${type.tipo}</option>`;
      });
      $('producto').innerHTML = template;
    }
  });
}

/**
 * Permite setear el evento submit al formulario para manejar
 * la creacion de un producto...
 * @return void
 */
const addSubmitEventFormAddProduct = () => {
  let formAddProd = $('agregarprod');
  formAddProd.addEventListener('submit', ev => {
    ev.preventDefault();
    crearRequest().then(request => {
      ajax({
        method: 'POST',
        url: 'api/productos.php',
        data: request,
        successCallback: response => {
          $('msg').innerHTML = `<div class="mg-alert alert alert-success alert-dismissible fade show" role="alert">
          ${response.msg}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
        </div>`
        }
      });
    });
  });
}

/**
 * Permite crear el request con los datos del formulario,
 * verifica si se seleccionó una imagen, si hay alguna la carga
 * y obtiene el base64
 * @return {Promise} request
 */
const crearRequest = () => {
  return new Promise((resolve, reject) => {
    let requestDefault = obtenerCampos();
    let img = $('img');
    if (img.files.length > 0) {
      getBase64(img.files[0]).then(base64 => {
        requestDefault.img = base64;
        resolve(requestDefault);
      });
    } else {
      resolve(requestDefault);
    }
  });
}

/**
 * Permite obtener los campos del formulario, devuelve un object
 * con los datos
 * @return {Object}
 */
const obtenerCampos = () => {
  let nombre = $('nombre');
  let descripcion = $('descripcion');
  let stock = $('stock');
  let precio = $('precio');
  let categoria = $('categoria');
  let producto = $('producto');
  return {
    nombre: nombre.value,
    descripcion: descripcion.value,
    stock: stock.value,
    precio: precio.value,
    fkidcat: categoria.value,
    fkidtipo: producto.value
  };
}
