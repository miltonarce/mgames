window.addEventListener("DOMContentLoaded", function() {
  recargarItems();
});

function recargarItems() {
  ajax({
    method: "GET",
    url: "api/productos.php",
    successCallback: function(rta) {
      let productos = JSON.parse(rta);
      let salida = "";

      productos.forEach(function(item) {
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
          "<td><a href='ver-pelicula.php?id=' data-id='#'><i class='material-icons'>border_color</i></a></td>";
        salida +=
          "<td><a href='ver-pelicula.php?id=' data-id='#'><i class='material-icons'>delete_forever</i></a></td>";
        salida += "</tr>";
      });
      document.getElementById("items").innerHTML = salida;
    }
  });
}
