<?php

$this->registerCss('.pagination {margin: -5px 0} ');

use
yii\bootstrap\Modal,
yii\helpers\Html,
yii\helpers\Url,
yii\widgets\Pjax,
kartik\dialog\Dialog,
kartik\grid\GridView;

app\assets\Plantillas::register($this);

$this->title = 'Datos de Plantillas';
$this->params['breadcrumbs'][] = $this->title;

/* El echo no muestra nada, solo para activar el asset bundle http://demos.krajee.com/dialog */
echo Dialog::widget([ 'options' => ['draggable'=>true] ]);

/****************************************************************************************************************/
/*********************************************** VENTANAS MODALES ***********************************************/
// Se muestra una ventana modal utilizando un formulario en views/plantillas/formplantilla.php

echo Html::button('Crear Plantilla',[
	'value'=>Url::to('crea-plantilla'),
	'class'=>'btn btn-success botonCreaPlantilla','style'=>'margin-bottom:30px;',
	'id'=>'botonCreaPlantilla'
]);

Modal::begin([
	'header'=>'<h3 style="text-align:center;background:#B44039;color:white"><span style="font-family:tahoma">Crear Plantilla</h3>',
	'id'=>'modalCreaPlantilla'
]);
echo '<div id="contenidoCreaPlantilla"></div>';
Modal::end();


/**
* Se muestra una ventana modal utilizando un formulario en views/plantillas/formplantilla.php, actualiza
*/
Modal::begin([
	'header'=>'<h3 style="text-align:center;background:#ceffe7">Actualiza Plantilla</h3>',
	'id'=>'modalActPlantilla'
]);
echo '<div id="contenidoActPlantilla"></div>';
Modal::end();
/****************************************************************************************************************/

$columnas = [
	[
		'class' => 'yii\grid\SerialColumn',  // Numerador
		'headerOptions' => ['style'=>'width:40px; text-align:center'],
		'contentOptions' => ['style' => 'width:40px; text-align:center;vertical-align:middle'],  // not max-width
	],
	[
		'attribute'=>'nombreplantilla',
		'hAlign'=>'left',
		'vAlign'=>'middle',
		'width'=>'300px',
	],
	[
		'class' => 'yii\grid\ActionColumn',
		'headerOptions' => ['style'=>'width:50px','class'=>'text-center'],
		'header'=>'Acción',
		'contentOptions' => ['class' => 'text-center'],
		//'template' => '{view} {update} {delete} {link}',
		'template' => '{update} {delete} {view}',
		'buttons' => [
			'update'=>function ($url, $model) {
				$url = Url::to(['actualiza-plantilla', 'regn' => $model->regn, 'nombreplantilla' => $model->nombreplantilla]);
				return Html::button('<span class="glyphicon glyphicon-pencil"></span>',[
					'data-url'=>Url::to($url), 'class' => 'btn btn-default btn-xs botonActPlantilla'
				]);
			},
			'delete' => function ($url, $model) {
				$url = Url::toRoute(['borra-plantilla']);
				return Html::a('', $url, [
					'class'     => 'btn btn-xs glyphicon glyphicon-trash borra-plantilla',
					'data-regn' => Yii::$app->funcion->cifrar($model->regn,date('d')),
					'data-url'  => $url,
				]);
			},
			'view'=>function ($url, $model) {
				$url = Url::to(['config-plantilla', 'titulo'=>$model->nombreplantilla,'regn'=>Yii::$app->funcion->cifrar($model->regn,date('d'))]);
				//  $url = Url::toRoute(['config-plantilla']);
				return Html::a('', $url, ['class' => 'btn btn-xs glyphicon glyphicon-sort-by-attributes']);
			},
		],
	],
]; //$columnas

Pjax::begin(['id'=>'grillaPlantillas']);
echo GridView::widget([
	'dataProvider' => $datosPlantillas,
	'columns' => $columnas,
	'responsive'=>true,
	'hover'=>true,
	'resizableColumns'=>true,
	'export' => false,  // Asi no hay necesidad de instalar la extensión MPDF
	// 'pjax' => true,
	'rowOptions' => ['class' => GridView::TYPE_ACTIVE]
]);
Pjax::end();
