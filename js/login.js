window.addEventListener('DOMContentLoaded', () => {
    addSubmitEventFormLogin();
});

/**
 * Permite agregar el evento submit al formulario de login,
 * autentica llamando al service /auth
 * @return void
 */
const addSubmitEventFormLogin = () => {
    let formLogin = $('formLogin');
    let request = obtenerInputsForm();
    formLogin.addEventListener('submit', ev => {
        $('errores').innerHTML = '';
        ev.preventDefault();
        let request = obtenerInputsForm();
        let errores = obtenerErroresLogin(request);
        if (esValidoFormLogin(errores)) {
            ajax({
                method: 'POST',
                url: 'api/auth.php',
                data: request,
                successCallback: response => {
                    if (response.status === 1) {
                        window.location.href = 'index.php';
                    } else {
                        $('errores').innerHTML = response.msg;
                    }
                }
            });
        } else {
            $('errores').innerHTML = `${errores.username} <br/> ${errores.password}`;
        }
    });
}

/**
 * Permite obtener los campos del formulario del login
 * @return {Object} request
 */
const obtenerInputsForm = () => {
    return {
        username:  $('username').value,
        password: $('password').value
    };
}

/**
 * Permite obtener los errores generados por el usuario en el formulario de login
 * @param {Object} request
 * @return {Object} errores
 */
const obtenerErroresLogin = request => {
    let errores = { username: '', password: '' };
    if (esVacio(request.username)) {
		errores.username = 'El campo usuario no puede ser vacío';
	}
	if (esVacio(request.password)) {
		errores.password += 'El campo password no puede ser vacío';
    }
    return errores;
}

/**
 * Permite verificar si el formulario es válido, y no hay errores
 * @param {Object} errores
 * @return boolean
 */
const esValidoFormLogin = errores => errores.username === '' && errores.password === '';