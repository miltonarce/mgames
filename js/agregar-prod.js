window.addEventListener('DOMContentLoaded', () => {
  getAllCategorias();
  getAllTipos();
  addSubmitEventFormAddProduct();
});

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
          $('msg').innerHTML = crearAlert('alert-success', response.msg);
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
