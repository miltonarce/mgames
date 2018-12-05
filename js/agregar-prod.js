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
  $('errores').innerHTML = '';
  $('errores').className = '';
  let formAddProd = $('agregarprod');
  formAddProd.addEventListener('submit', ev => {
    ev.preventDefault();
    let errores = obtenerErrores(obtenerCampos());
    if (esValidoElForm(errores)) {
      crearRequest().then(request => {
        ajax({
          method: 'POST',
          url: 'api/productos.php',
          data: request,
          successCallback: response => {
            crearAlert('alert-success', response.msg);
            formAddProd.reset();
          }
        });
      });
    } else {
      $('errores').className = 'alert alert-warning';
      $('errores').innerHTML = `${errores.nombre} <br/> ${errores.descripcion} <br/> ${errores.precio} <br/> ${errores.stock} <br/>`;
    }
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

