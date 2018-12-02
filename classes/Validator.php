<?php

/**
 * Clase Validator , se encarga de manejar las validaciones de los campos recibidos en las consultas...
 */
class Validator
{

	protected $data;
	protected $reglas;
	protected $errores = [];

	/**
	 * Constructor.
	 *
	 * @param array $data Los datos a validar.
	 * @param array $reglas Las reglas de validación a aplicar.
	 */
	public function __construct($data, $reglas)
	{
		$this->data 	= $data;
		$this->reglas 	= $reglas;
		$this->validate();
	}

	/**
	 * Ejecuta las validaciones.
	 */
	public function validate()
	{
		foreach($this->reglas as $nombreCampo => $reglasCampo) {
			$this->aplicarReglas($nombreCampo, $reglasCampo);
		}
	}

	/**
	 * Aplica las $reglas de validación al $campo.
	 *
	 * @param string $campo
	 * @param array $reglas
	 */
	public function aplicarReglas($campo, $reglas)
	{
		foreach($reglas as $unaRegla) {
			if(strpos($unaRegla, ":") == false) {
				$method = "_" . $unaRegla;
				$this->{$method}($campo);
			} else {
				$partes = explode(':', $unaRegla);
				$method = "_" . $partes[0];
				$this->{$method}($campo, $partes[1]);
			}
		}
	}

	/**
	 * Verifica si la validación pasó exitosamente.
	 */
	public function passes()
	{
		return empty($this->errores);
	}

	/**
	 * Guarda el $mensaje para el $campo en la propiedad errores.
	 *
	 * @param string $campo
	 * @param string $mensaje
	 */
	public function setError($campo, $mensaje)
	{
		$this->errores[$campo] = $mensaje;
	}

	/**
	 * Retorna el array de errores.
	 *
	 * @return array
	 */
	public function getErrores()
	{
		return $this->errores;
	}

	/**
	 * Retorna true si el $campo tiene un valor. false de lo contrario.
	 *
	 * @param string $campo
	 * @return bool
	 */
	protected function _required($campo)
	{
		$valor = $this->data[$campo];
		if(empty($valor)) {
			$this->setError($campo, 'Este campo no debe estar vacío.');
			return false;
		}
		return true;
	}

	/**
	 * Retorna true si el $campo tiene al menos $longitud caracteres. false de lo contrario.
	 *
	 * @param string $campo
	 * @param int $longitud
	 * @return bool
	 */
	protected function _min($campo, $longitud)
	{
		$valor = $this->data[$campo];
		if(strlen($valor) < $longitud) {
			$this->setError($campo, 'Este campo debe tener al menos ' . $longitud . ' caracteres.');
			return false;
		}
		return true;
	}

	/**
	 * Retorna true si el $campo es un valor numérico. false de lo contrario.
	 *
	 * @param string $campo
	 * @return bool
	 */
	protected function _numeric($campo)
	{
		$valor = $this->data[$campo];
		if(!is_numeric($valor)) {
			$this->setError($campo, 'Este campo debe ser numérico.');
			return false;
		}
		return true;
	}
	
}