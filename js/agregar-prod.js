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



