/**
 * Permite realizar una consulta por AJAX, soporta los métodos de REST
 * options {
 * 	data: data a enviar 
 * 	method: metodo GET,PUT,DELETE,POST
 * 	successCallback: si sale todo ok, la función a ejecutar
 * 	errorCallback: si hay un error, la función a ejecutar
 * }
 * @param {Object} options
 * @return void
 */
const ajax = options => {
  let xMLHttpRequest = new XMLHttpRequest();
	let data = null;
	let url = options.url;
	let method = options.method ? options.method : 'GET';
	if (options.data) {
		if (method.toUpperCase() === 'GET') {
			url += '?' + options.data;
		} 
		else {
			data = JSON.stringify(options.data);
		}
	}
	xMLHttpRequest.open(method, url);
	xMLHttpRequest.addEventListener('readystatechange', () => {
		if (xMLHttpRequest.readyState === 4) {
			xMLHttpRequest.status === 200 ? options.successCallback(JSON.parse(xMLHttpRequest.responseText)) : options.errorCallback('Se produjo un error');
		}
	});
	if(method.toUpperCase() === 'POST') {
		xMLHttpRequest.setRequestHeader('Content-Type', 'application/json');
	}
	xMLHttpRequest.send(data);
}

/**
 * Permite obtener los elementos por el id del mismo, es
 * un wrapper a la funcion document.getElementById
 * @param id
 * @return {Element}
 */
const $ = id => document.getElementById(id);

/**
 * Permite obtener el base64 de la imagen, devuelve una promise
 * con el resultado...
 * @param {File} 
 * @return {Promise}
 */
const getBase64 = file => {
	return new Promise((resolve, reject) => {
		const reader = new FileReader();
		reader.addEventListener('load', () => resolve(reader.result));
		reader.readAsDataURL(file);
	});
}

/**
 * Permite crear un alert de boostrap con la clase recibida por parametro
 * por default es sucess, clases posibles (alert-primary, alert-danger, alert-warning, alert-info) ...
 * Agrega el event click al button para cerrarlo...
 * @param {string} type 
 * @param {string} msg 
 * @return void
 */
const crearAlert = (type = 'alert-success' , msg) => {
	let alert = `<div class="mg-alert alert alert-dismissible fade show ${type}" role="alert">
					${msg}
					<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>`;
	$('msg').innerHTML = alert;
	let button = document.querySelector('button[data-dismiss]');
	button.addEventListener('click', () => button.parentNode.classList.remove('show')); 
}

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

const esVacio = valor => valor.trim() == '';

const esNumero = valor => !isNaN(valor);

const superaCantidadMinima = valor => valor.length > 3;

const obtenerErrores = data => {
	let errores = {
		nombre: '',
		descripcion: '',
		precio: '',
		stock: ''
	};
	if (esVacio(data.nombre)) {
		errores.nombre += 'El campo nombre no puede ser vacío';
	}
	if (esVacio(data.descripcion)) {
		errores.descripcion += 'El campo descripción no puede ser vacío';
	}
	if (!superaCantidadMinima(data.descripcion)) {
		errores.descripcion += '<br/> mínimo 3 caracteres';
	}
	if (esVacio(data.precio)) {
		errores.precio += 'El campo precio no puede ser vacío';
	}
	if (!esNumero(data.precio)) {
		errores.precio += 'El campo precio tiene que ser un número';
	}
	if (esVacio(data.stock)) {
		errores.stock += 'El campo stock no puede ser vacío';
	}
	if (!esNumero(data.stock)) {
		errores.stock += 'El campo stock tiene que ser un número';
	}
	return errores;
}

const esValidoElForm = errores => errores.nombre == '' && errores.descripcion == '' && errores.precio == '' && errores.stock == '';


