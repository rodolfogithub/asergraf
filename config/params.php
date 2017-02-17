<?php
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
	return [
		'adminEmail' => 'aochoa@asercol.com',
		'title' => 'Generación de gráficos (Windows)',
      'empresa' => 'ASERCOL S.A.'
	];
} else {
	return [
		'adminEmail' => 'aochoa@asercol.com',
		'title' => 'Generación de gráficos ',
      'empresa' => 'ASERCOL S.A.'
	];
}
