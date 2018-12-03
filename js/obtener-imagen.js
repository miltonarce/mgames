/**
 * Permite obtener el base64 de la imagen, devuelve una promise
 * con el resultado...
 * @param {File} 
 * @return {Promise}
 */
function getBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.addEventListener('load', () => resolve(reader.result));
        reader.readAsDataURL(file);
    });
}