window.addEventListener("DOMContentLoaded", function () {
  recargarItems();
});

function recargarItems() {
  ajax({
    method: "GET",
    url: "api/productos.php",
    successCallback: rta => {
      let productos = JSON.parse(rta);
      let salida = "";

      productos.forEach(item => {
        salida += "<tr>";
        salida += "<td>" + item.idproducto + "</td>";
        salida +=
          "<td><img class='img-thumbnail' src='uploads/" +
          item.img +
          "' alt='Imagen Producto'/></td>";
        salida += "<td>" + item.nombre + "</td>";
        salida += "<td>" + item.descripcion + "</td>";
        salida += "<td>" + item.stock + "</td>";
        salida +=
          "<td><strong class='badge badge-success'>$" +
          item.precio +
          "</strong></td>";
        salida +=
          "<td><strong class='badge badge-secondary'>" +
          item.fecha_alta +
          "</strong></td>";
        salida += "<td>" + item.fkidcat + "</td>";
        salida += "<td>" + item.fkidtipo + "</td>";
        salida +=
          "<td><a href='#' data-id='#'><i class='material-icons'>border_color</i></a></td>";
        salida +=
          "<td><a href='#' data-id-remove='" + item.idproducto + "'><i class='material-icons'>delete_forever</i></a></td>";
        salida += "</tr>";
      });
      document.getElementById("items").innerHTML = salida;
      removeEventListener();
    }
  });
}

function removeEventListener() {
  elements = document.querySelectorAll('a[data-id-remove]');
  elements.forEach(e => {
    e.addEventListener("click", (el) => {
      ajax({
        method: "DELETE",
        url: "api/productos.php?id=" + el.path[1].attributes[1].value,
        successCallback: rta => {
          let response = JSON.parse(rta);
          console.log(response);
        }
      });
      console.log(el.path[1].attributes[1].value);
    });
  });
}