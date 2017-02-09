<?php

use app\models\Itemsgraficos;
use yii\helpers\Html;

$this->title = 'Gráficos estadísticos';

app\assets\EstiloTabla::register($this);

$this->title = 'Gráficos';

echo yii\helpers\Html::a('<span class="pull-right glyphicon glyphicon-sunglasses"><span style="font-family: Helvetica; font-size: 1.5em">&nbsp;Inicio',
   ['/graficos']);
/**
* Se determina que tipo de gráfico es para el Y y para el eje Y2
*/
function tipoGrafico($datos)
{
   $tipograf = [];
   foreach($datos as $key=>$valor) {
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
   $ejeY = [];   $ejeY2 = [];
   foreach($datos as $key=>$valor) {
      if (strpos(strtoupper($key),'Y_') !== false) $ejeY[substr($key,2)] = substr($key,0,1);
      if (strpos(strtoupper($key),'Y2_') !== false) $ejeY2[substr($key,3)] = substr($key,0,2);
   }
   return $ejeY + $ejeY2;
}

/* Si hay varios campos empezando con y_ */
function serieDatosY($datos)
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
$colorBarras = [0=>'#1f77b4',1=>'#a27e57',2=>'#4d88c8'];

/**
* Se genera el menú para seleccionar el tipo de gráfica
*
*/
$nomcapitulo = '';   $capitulo = 1;

echo '<div id="menuPrincipal">';
foreach ($traeDatos as $grafico) {
   if ($nomcapitulo <> $grafico['nombrecapitulo']) {
      echo '<div class="menuasercol col-centered" style="margin-top:20px">'.$grafico['nombrecapitulo'].'</div>';
      $nomcapitulo = $grafico['nombrecapitulo'];
   }
   echo Html::a('<div class="text-center" style="padding-top:10px"><span class="glyphicon glyphicon-cog"><span style="font-family: Helvetica;font-size:1.5em">&nbsp;'.
      $grafico['titulo'].'</div>', '#capit'.$capitulo);
   $capitulo++;
}
echo '</div>';

?>

<div class="row text-right" style="padding-bottom: 20px;">
   <?=Html::button('<span class="glyphicon glyphicon-print"></span> Imprimir',[
      'class' => 'btn btn-default btn-lg',
      'onclick' => 'window.print()'
   ]);?>
</div>

<?php
/**********************************************************************************************
*                          Inicio de recorrido de gráficas por cliente                        *
***********************************************************************************************/

foreach ($traeDatos as $grafico) {                      // $traeDatos = todos los registros,  $grafico = un solo registro
   $idGrafico++;
   $seriesY = [];    $seriesY2 = [];                    // Serie de datos

   /* Se crean las seriesY */
   for ($idx = 1; $idx < 4; $idx++) ${'datosY_'.($idx)} = [];
   /* Se crean las seriesY2 */
   for ($idx = 1; $idx < 3; $idx++) ${'datosY2_'.($idx)} = [];

   $categorias  = [];   // EJE X
   $tipoDatos = [];
   $tipoEjes = [];

   $sql = $grafico['sql'];
   $traeDatosSQL = Itemsgraficos::traeDatosSQL($sql);   // Ejecuta instrucción SQL según campo sql en $grafico

   foreach ($traeDatosSQL as $datossql) {               // $traeDatosSQL = registros del SQL, $datossql = un registro asignado
      $i = 0;                                           // Indice del arreglo $datossql para extraer información
      $tipoDatos = tipoGrafico($datossql);
      $tipoEjes = tipoEje($datossql);
      $seriesY  = serieDatosY($datossql);
      $seriesY2 = serieDatosY2($datossql);
      $pasoY = false;  $pasoY2 = false;

      foreach(array_keys($datossql) as $key) {
         if (strpos(strtoupper($key),'X_') !== false) {    // Categorias eje X
            array_push($categorias,array_values($datossql)[$i]);
            $labEjex = substr(array_keys($datossql)[$i],2);// Nombre del eje x, (primera columna en tabla)
         }

         if ($pasoY == false && strpos(strtoupper($key),'Y_') !== false) { // Eje Y
            for ($idx=0; $idx<count($seriesY); $idx++) {
               if (empty(${'datosY_'.($idx+1)})) ${'datosY_'.($idx+1)} = explode(',',array_keys($seriesY[$idx])[0]); // Pone el nombre asignado en la columna del SQl en $datosY_idx[0]
               array_push(${'datosY_'.($idx+1)}, array_values($datossql)[array_values($seriesY[$idx])[0]]);          // Pone el valor de acuerdo al nombre de la columna
            }
            $pasoY = true;
         }

         if ($pasoY2 == false && strpos(strtoupper($key),'Y2_') !== false) { // Eje Y2
            for ($idx=0; $idx<count($seriesY2); $idx++) {
               if (empty(${'datosY2_'.($idx+1)})) ${'datosY2_'.($idx+1)} = explode(',',array_keys($seriesY2[$idx])[0]); // Pone el nombre asignado en la columna del SQl en $datosY2_idx[0]
               array_push(${'datosY2_'.($idx+1)}, array_values($datossql)[array_values($seriesY2[$idx])[0]]);           // Pone el valor de acuerdo al nombre de la columna
            }
            $pasoY2 = true;
         }

         $i++;
      }  // foreach

   }  // foreach, fin del bucle con los datos de la Gráfica listos

   // Solo asigna colores para barras
   $colors = [];
   for ($c=0; $c<count($tipoDatos); $c++) {
      if (array_values($tipoDatos)[$c] == 'bar') $colors += [array_keys($tipoDatos)[$c]=>$colorBarras[$c]];
   }
   if (!empty($datosY2_1)) $colors[$datosY2_1[0]] = 'orange';
   if (!empty($datosY2_2)) $colors[$datosY2_2[0]] = 'green';  //'#00d700' verde mas claro;

   /* se determina que serie de Y2 es mayor para etiquetear el eje Y2, sino hay series $labelY2 = '' */
   $vlrY2_1 = 0;  $vlrY2_2 = 0;
   for ($j=1; $j<count($datosY2_1); $j++) $vlrY2_1 += $datosY2_1[$j];
   for ($j=1; $j<count($datosY2_2); $j++) $vlrY2_2 += $datosY2_2[$j];
   $labelY2 = empty($datosY2_1) ? '' : (empty($datosY2_2) ? $datosY2_1[0] : ($vlrY2_1 > $vlrY2_2) ? $datosY2_1[0] : $datosY2_2[0]);

   $capitulo = $grafico['nombrecapitulo'];
   $titulo = $grafico['titulo'];

   switch (array_values($tipoDatos)[0]) {
      case 'bar':
         echo $this->render('_grafBarras',
            compact(
               'idGrafico','categorias','datosY_1', 'datosY_2', 'datosY_3', 'datosY2_1','datosY2_2',
               'tipoEjes','tipoDatos','colors','labelY2','labEjex','capitulo','titulo'
            )
         );
         break;
      case 'pie':
         echo $this->render('_grafPie',compact('idGrafico','categorias','datosY_1','labEjex','capitulo','titulo') );
         break;
   }

   echo yii\helpers\Html::button('',['title'=>'Ir al principio','onClick'=>'js:window.scrollTo(0, 0)','class'=>'btn btn-lg btn-success glyphicon glyphicon-triangle-top']);

   echo '<div class="saltopagina"></div>';
}  // foreach
