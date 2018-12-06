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
	if (method.toUpperCase() === 'POST') {
		xMLHttpRequest.setRequestHeader('Content-Type', 'application/json');
	}
	xMLHttpRequest.send(data);
}

/**
 * Permite obtener los elementos por el id del mismo, es
 * un wrapper a la funcion document.getElementById
 * @param {string} id
 * @return Element
 */
const $ = id => document.getElementById(id);

/**
 * Permite obtener el base64 de la imagen, devuelve una promise
 * con el resultado...
 * @param {File}  file
 * @return Promise
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
const crearAlert = (type = 'alert-success', msg) => {
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
 * @param {number} idprod
 * @param {number} idC
 * @return void
 */
const getAllCategorias = (idprod, idC) => {
	ajax({
		method: 'GET',
		url: 'api/categorias.php',
		successCallback: response => {
			let template = '';
			response.forEach(cat => {
				const isSelected = (idp, idC, cidp) => (idp && idC === cidp ? 'selected' : '')
				template += `<option value="${cat.idcat}" ${isSelected(idprod, idC, cat.idcat)}>${cat.categoria}</option>`;
			});
			$('categoria').innerHTML = template;
		}
	});
}

/**
 * Permite obtener todos los tipos disponbiles que existen,
 * genera el html correspondiente, para popular el select...
 * @param {number} idprod
 * @param {number} idT
 * @return void
 */
const getAllTipos = (idprod, idT) => {
	ajax({
		method: 'GET',
		url: 'api/tipos.php',
		successCallback: response => {
			let template = '';
			response.forEach(function (type) {
				const isSelected = (idp, idT, tidp) => (idp && idT === tidp ? 'selected' : '')
				template += `<option value="${type.idTipo}" ${isSelected(idprod, idT, type.idTipo)}>${type.tipo}</option>`;
			});
			$('producto').innerHTML = template;
		}
	});
}

/**
 * Permite validar si es vacío el campo
 * @param {string} valor 
 * @return boolean
 */
const esVacio = valor => valor.trim() == '';

/**
 * Permite validar si el valor ingresado es un número
 * @param {number | string} valor
 * @return boolean
 */
const esNumero = valor => !isNaN(valor);

/**
 * Permite saber si el valor supera una cantidad minima, en este caso 3
 * @param {number} valor
 * @return boolean
 */
const superaCantidadMinima = valor => valor.length > 3;

/**
 * Permite obtener los errores que pueden ocurrir al llamar al formulario
 * @param {Object} data
 * @return errores
 */
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

/**
 * Permite obtener los campos del formulario, devuelve un object
 * con los datos
 * @return Object
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

/**
 * Permite saber si no hubo errores y es valido el form
 * @param {Object} errores
 * @return boolean
 */
const esValidoElForm = errores => errores.nombre == '' && errores.descripcion == '' && errores.precio == '' && errores.stock == '';

/**
 * Permite crear el request con los datos del formulario,
 * verifica si se seleccionó una imagen, si hay alguna la carga
 * y obtiene el base64
 * @return Promise
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
