<?php
namespace app\components;

use yii\base\Object;

class funcionesComponent extends Object
{
	/**
	* Tomado de http://www.the-art-of-web.com/php/blowfish-crypt/
	* @link Original PHP code by Chirp Internet: www.chirp.com.au
	*/
	function better_crypt($input, $rounds = 10) {
		$crypt_options = ['cost' => $rounds];
		return password_hash($input, PASSWORD_BCRYPT, $crypt_options);  // Se usa el algoritmo BlowFish, el resultado siembre será de 60 caracteres.
	}

	/**
	* Cifra un texto y si es continuo como 1,2,3 la salida no tiene un consecutivo visual
	*
	* @param mixed $string
	* @param mixed $secret_key
	*/
	function cifrar($string,$secret_key='19') {
		$output = false;

		$encrypt_method = "AES-256-CBC";
		$secret_iv = 'This is my secret iv';

		// hash
		$key = hash('sha256', $secret_key);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
		$output = base64_encode($output);

		return $output;
	}

	/**
	* Si se cifra el valor 1 y despúes 2 y depués 3 y asi sucesivamente las salidas respectivas no tienen
	* relación entre si.
	*
	* @param mixed $string
	* @param mixed $secret_key
	*/
	function descifrar($string,$secret_key='19') {
		$output = false;

		$encrypt_method = "AES-256-CBC";
		$secret_iv = 'This is my secret iv';

		// hash
		$key = hash('sha256', $secret_key);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

		return $output;
	}

	/**
	* @property integer $ceros
	* @return Llena de 0's a la izquierda
	*/
	public function llenaceros($numero,$ceros)
	{
		$dif = $ceros - strlen($numero);
		for($m = 0 ;$m < $dif; $m++) @$insertar_ceros .= 0;

		return $insertar_ceros .= $numero;
	}

	/**
	* Calcula la edad parametro a pasar es YYYY-MM-DD
	*
	* @param mixed $fecha
	*/
	function calculaEdad( $fecha ) {
		list($Y,$m,$d) = explode("-",$fecha);
		return (date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y);
	}

	/**
	* Para generar passwords de hasta 8 digitos.
	*
	* Para mayor seguridad usar better_crypt primera función declarada.
	*/
	public function randomPassword() {
		$alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < 8; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		return implode($pass); //turn the array into a string
	}


}