window.addEventListener("DOMContentLoaded", function() {
  recargarCategorias();
  recargarTipo();
});

function recargarCategorias() {
  ajax({
    method: "GET",
    url: "api/categorias.php",
    successCallback: function(rta) {
      let categorias = JSON.parse(rta);
      let salida = "";
      categorias.forEach(function(cats) {
        salida +=
          "<option value='" + cats.idcat + "' >" + cats.categoria + "</option>";
      });
      document.getElementById("categoria").innerHTML = salida;
    }
  });
}

function recargarTipo() {
  ajax({
    method: "GET",
    url: "api/tipos.php",
    successCallback: function(rta) {
      let tipos = JSON.parse(rta);
      let salida = "";
      tipos.forEach(function(tips) {
        salida +=
          "<option value='" + tips.idtipo + "' >" + tips.tipo + "</option>";
      });
      document.getElementById("producto").innerHTML = salida;
    }
  });
}
