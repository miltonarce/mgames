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