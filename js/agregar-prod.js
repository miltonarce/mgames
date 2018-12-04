window.addEventListener("DOMContentLoaded", function () {
  recargarCategorias();
  recargarTipo();
});
// obtengo el form agregar prod
let formAddProd = $('agregarprod');

formAddProd.addEventListener('submit', ev => {
  ev.preventDefault();
  //Obtengo los campos del form
  let nombre = $('nombre');
  let descripcion = $('descripcion');
  let stock = $('stock');
  let precio = $('precio');
  let categoria = $('categoria');
  let producto = $('producto');
  let imagen = $('imagen');
  if (imagen.files.length > 0) {
    getBase64(imagen.files[0]).then(base64 => {
      imagen = base64;
    });
  }
  let data = {
    nombre: nombre.value,
    descripcion: descripcion.value,
    stock: stock.value,
    precio: precio.value,
    fkidcat: categoria.value,
    fkidtipo: producto.value
  }

  ajax({
    method: 'POST',
    url: 'api/productos.php',
    data: JSON.stringify(data),
    successCallback: rta => {
      let response = JSON.parse(rta);
      document.getElementById('msg').innerHTML = `<div class="mg-alert alert alert-success alert-dismissible fade show" role="alert">
       ${response.msg}
       <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
       </button>
     </div>`
    }
  });
});



function recargarCategorias() {
  ajax({
    method: "GET",
    url: "api/categorias.php",
    successCallback: function (rta) {
      let categorias = JSON.parse(rta);
      let salida = "";
      categorias.forEach(function (cats) {
        salida +=
          "<option value='" + cats.idcat + "' >" + cats.categoria + "</option>";
      });
      $("categoria").innerHTML = salida;
    }
  });
}

function recargarTipo() {
  ajax({
    method: "GET",
    url: "api/tipos.php",
    successCallback: function (rta) {
      let tipos = JSON.parse(rta);
      let salida = "";
      tipos.forEach(function (tips) {
        salida +=
          "<option value='" + tips.idTipo + "' >" + tips.tipo + "</option>";
      });
      $("producto").innerHTML = salida;
    }
  });
}
