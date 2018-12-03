window.addEventListener('DOMContentLoaded', () => {
  recargarItems();
});

const recargarItems = () => {
  ajax({
    method: 'GET',
    url: 'api/productos.php',
    successCallback: response => {
      let productos = JSON.parse(response);
      document.getElementById('items').innerHTML = generarTemplate(productos);
      agregarDeleteEventListener();
    }
  });
}

const generarTemplate = productos => {
  let template = '';
  productos.forEach(producto => {
    template+= `<tr>
      <td>${producto.idproducto}</td>
      <td><img class="img-thumbnail" src="uploads/${producto.img}" alt="imagen de ${producto.nombre}" /></td>
      <td>${producto.nombre}</td>
      <td>${producto.descripcion}</td>
      <td>${producto.stock}</td>
      <td><strong class="badge badge-success">$ ${producto.precio}</strong></td>
      <td><strong class="badge badge-secondary">${producto.fecha_alta}</strong></td>
      <td>${producto.categoria.categoria}</td>
      <td>${producto.tipo.tipo}</td>
      <td><a href="#" data-id="#"><i class="material-icons">border_color</i></a></td>
      <td><a href="#" data-id-remove="${producto.idproducto}"><i class="material-icons">delete_forever</i></a></td>
    </tr>`
  });
  return template;
}

const agregarDeleteEventListener = () => {
  let elements = document.querySelectorAll('a[data-id-remove]');
  elements.forEach(element => {
    element.addEventListener('click', el => {
      ajax({
        method: 'DELETE',
        url: `api/productos.php?id=${el.path[1].attributes[1].value}`,
        successCallback: rta => {
          let response = JSON.parse(rta);
          console.log(response);
        }
      });
      console.log(el.path[1].attributes[1].value);
    });
  });
}
