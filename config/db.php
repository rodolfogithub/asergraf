<?php
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	return [
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=localhost:3307;dbname=estadistica',
		'username' => 'root',
		'password' => 'rasoft',
		'charset' => 'utf8',
	];
} else {
	return [
		'class' => 'yii\db\Connection',
		'dsn' => 'mysql:host=dnjs2.wnkserver2.com;dbname=rasoftco_tenis',
		'username' => 'rasoftco_Rasoft',
		'password' => 'zrzKTD]1TmE)',
		'charset' => 'utf8',
	];
}
