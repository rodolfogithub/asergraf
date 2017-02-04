<?php

use app\models\Itemsgraficos;

$this->title = 'Gráficos estadísticos';

/**
* Se determina que tipo de gráfico es para el Y y para el eje Y2
*/
function tipoGrafico($datos)
{
	$tipograf = [];
	foreach($datos as $key=>$valor) {
		$a = $key;
		if ($key=='y') $tipograf[$key] = $valor;
		if ($key=='y2') $tipograf[$key] = $valor;
	}
	$ejeY = []; 	$ejeY2 = [];
	foreach($datos as $key=>$valor) {
		if (strpos(strtoupper($key),'Y_') !== false) $ejeY[substr($key,2)] = $tipograf['y'];
		if (strpos(strtoupper($key),'Y2_') !== false) $ejeY2[substr($key,3)] = $tipograf['y2'];
	}
	return $ejeY + $ejeY2;
}

/* Se determina que tipo de eje le corresponde a los nombres de las columnas del SQL */
function tipoEje($datos)
{
	$tipoeje = [];   $ejeY = [];   $ejeY2 = [];
	foreach($datos as $key=>$valor) {
		if (strpos(strtoupper($key),'Y_') !== false) $ejeY[substr($key,2)] = substr($key,0,1);
		if (strpos(strtoupper($key),'Y2_') !== false) $ejeY2[substr($key,3)] = substr($key,0,2);
	}
	return $ejeY + $ejeY2;
}

/* Si hay varios campos empezando con y_ */
function serieDatosY1($datos)
{
	$ejeY1 = [];  $i = 0;  $idx = 0;
	foreach($datos as $key=>$valor) {
		if (strpos(strtoupper($key),'Y_') !== false) {
			$ejeY1[$idx] = [substr($key,2)=>$i];	$idx++;
		}
		$i++;
	}
	return $ejeY1;
}

/* Si hay varios campos empezando con y2_ */
function serieDatosY2($datos)
{
	$ejeY2 = [];  $i = 0;  $idx = 0;
	foreach($datos as $key=>$valor) {
		if (strpos(strtoupper($key),'Y2_') !== false) {
			$ejeY2[$idx] = [substr($key,3)=>$i];   $idx++;
		}
		$i++;
	}
	return $ejeY2;
}

$idGrafico = 0;

foreach ($traeDatos as $grafico) {                      // $traeDatos = todos los registros,  $grafico = un solo registro
	$idGrafico++;
	$datosY_1 = [];   $datosY_2 = [];  $datosY_3 = [];   // Hasta 3 series de datos en el eje Y
	$datosY2_1 = [];  $datosY2_2 = [];                   // Hasta 2 series de datos en el eje Y2
	$seriesY = [];    $seriesY2 = [];                    // Serie de datos

	$categorias  = [];   // EJE X
	$tipoDatos = [];
	$tipoEjes = [];

	$sql = $grafico['sql'];
	$traeDatosSQL = Itemsgraficos::traeDatosSQL($sql);   // Ejecuta instrucción SQL según campo sql en $grafico

	foreach ($traeDatosSQL as $datossql) {               // $traeDatosSQL = registros del SQL, $datossql = un registro asignado
		$i = 0;                                           // Indice del arreglo $datossql para extraer información
		$tipoDatos = tipoGrafico($datossql);
		$tipoEjes = tipoEje($datossql);
		$seriesY  = serieDatosY1($datossql);
		$seriesY2 = serieDatosY2($datossql);
		$pasoY = false;  $pasoY2 = false;

		foreach(array_keys($datossql) as $key) {
			if (strpos(strtoupper($key),'X_') !== false) {    // Categorias eje X
				array_push($categorias,array_values($datossql)[$i]);
				$labEjex = substr(array_keys($datossql)[$i],2);// Nombre del eje x, (primera columna en tabla)
			}

			if ($pasoY == false && strpos(strtoupper($key),'Y_') !== false) { // Eje Y
				for ($idx=0; $idx<count($seriesY); $idx++) {
					if ($idx==0) {
						if (empty($datosY_1)) array_push($datosY_1,array_keys($seriesY[0])[0]);      // Pone el nombre asignado en la columna del SQl en $datosY_1[0]
						array_push($datosY_1,array_values($datossql)[array_values($seriesY[0])[0]]); // Pone el valor de acuerdo al nombre de la columna
					}
					if ($idx==1) {
						if (empty($datosY_2)) array_push($datosY_2,array_keys($seriesY[1])[0]);      // Pone el nombre asignado en la columna del SQl en $datosY_2[0]
						array_push($datosY_2,array_values($datossql)[array_values($seriesY[1])[0]]); // Pone el valor de acuerdo al nombre de la columna
					}
					if ($idx==1) {
						if (empty($datosY_3)) array_push($datosY_3,array_keys($seriesY[1])[0]);      // Pone el nombre asignado en la columna del SQl en $datosY_3[0]
						array_push($datosY_3,array_values($datossql)[array_values($seriesY[1])[0]]); // Pone el valor de acuerdo al nombre de la columna
					}
				}
				$pasoY = true;
			}

			if ($pasoY2 == false && strpos(strtoupper($key),'Y2_') !== false) { // Eje Y2
				for ($idx=0; $idx<count($seriesY2); $idx++) {
					if ($idx==0) {
						if (empty($datosY2_1)) array_push($datosY2_1,array_keys($seriesY2[0])[0]);      // Pone el nombre asignado en la columna del SQl en $datosY2_1[0]
						array_push($datosY2_1,array_values($datossql)[array_values($seriesY2[0])[0]]);  // Pone el valor de acuerdo al nombre de la columna
					}
					if ($idx==1) {
						if (empty($datosY2_2)) array_push($datosY2_2,array_keys($seriesY2[1])[0]);      // Pone el nombre asignado en la columna del SQl en $datosY2_2[0]
						array_push($datosY2_2,array_values($datossql)[array_values($seriesY2[1])[0]]);  // Pone el valor de acuerdo al nombre de la columna
					}
				}
				$pasoY2 = true;
			}

			$i++;
		}  // foreach

	}  // foreach, fin del bucle con los datos de la Gráfica listos

	$colors = [array_keys($tipoDatos)[0]=>'#1f77b4'];  // Las barras serán del color #1f77b4
	if (!empty($datosY2_1)) $colors[$datosY2_1[0]] = 'orange';
	if (!empty($datosY2_2)) $colors[$datosY2_2[0]] = 'green';  //'#00d700' verde mas claro;

	/* se determina que serie de Y2 es mayor para etiquetear el eje Y2, sino hay series $labelY2 = '' */
	$vlrY2_1 = 0;  $vlrY2_2 = 0;
	for ($j=1; $j<count($datosY2_1); $j++) $vlrY2_1 .= $datosY2_1[$j];
	for ($j=1; $j<count($datosY2_2); $j++) $vlrY2_2 .= $datosY2_2[$j];
	$labelY2 = empty($datosY2_1) ? '' : (empty($datosY2_2) ? $datosY2_1[0] : ($vlrY2_1 > $vlrY2_2) ? $datosY2_1[0] : $datosY2_2[0]);

	switch (array_values($tipoDatos)[0]) {
		case 'bar':
			echo $this->render('_grafBarras',
				compact(
					'idGrafico','datosY_1', 'datosY_2', 'datosY_3', 'datosY2_1','datosY2_2',
					'tipoEjes','tipoDatos','colors','categorias','labelY2','labEjex'
				)
			);
			break;
		case 'pie':
			echo $this->render('_grafBarras',
				compact(
					'idGrafico','datosY_1', 'datosY_2', 'datosY_3', 'datosY2_1','datosY2_2',
					'tipoEjes','tipoDatos','colors','categorias','labelY2','labEjex'
				)
			);
			break;
	}

}  // foreach

?>

