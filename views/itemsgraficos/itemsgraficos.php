<?php

$this->registerCss('
   .pagination {margin: -5px 0}
   .modal-lg { width: 1010px;}
');

use
yii\bootstrap\Modal,
yii\helpers\Html,
yii\helpers\Url,
yii\widgets\Pjax,
kartik\dialog\Dialog,
kartik\grid\GridView;

app\assets\Itemsgrafico::register($this);

$this->title = 'Datos de Items Gráfico';
//$this->params['breadcrumbs'][] = ['label' => 'Gestión de datos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

/* El echo no muestra nada, solo para activar el asset bundle http://demos.krajee.com/dialog */
echo Dialog::widget([ 'options' => ['draggable'=>true] ]);

/****************************************************************************************************************/
/*********************************************** VENTANAS MODALES ***********************************************/

// Se muestra una ventana modal utilizando un formulario en views/itemsgrafico/formitemsgrafico.php
echo Html::button('Crear Item Gráfico',[
   'data-url'=>Url::toRoute('/itemsgraficos/crea-item'),
   'class'=>'btn btn-success','style'=>'margin-bottom:30px;',
   'id'=>'botonCreaItem'
]);
Modal::begin([
   'header'=>'<h3 style="text-align:center;background:#B44039;color:white"><span style="font-family:tahoma">Crear Items Gráfico</h3>',
   'id'=>'modalCreaItem',
   'size'=>'modal-lg'
]);
echo '<div id="contenidoCreaItem"></div>';
Modal::end();


/**
* Se muestra una ventana modal utilizando un formulario en views/itemsgrafico/formitems.php, actualiza
*/
Modal::begin([
   'header'=>'<h3 style="text-align:center;background:#ceffe7">Actualiza Items Gráfico</h3>',
   'id'=>'modalActItem',
   'size'=>'modal-lg'
]);
echo '<div id="contenidoActItem"></div>';
Modal::end();
/****************************************************************************************************************/

$columnas = [
   // the name column configuration
   [
      'class' => 'yii\grid\SerialColumn',  // Enumerador
      'headerOptions' => ['style'=>'width:40px; text-align:center'],
      'contentOptions' => ['style' => 'width:40px; text-align:center;vertical-align:middle'],  // not max-width
   ],
   //   ['class' => 'yii\grid\CheckboxColumn'],
   [
      'attribute'=>'titulo',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'width'=>'300px',
      'headerOptions' => ['style'=>'color:yellow'],
      //'hAlign'=>'center',
   ],
   [
      'attribute'=>'nomgrafico',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'width'=>'250px',
      'pageSummary'=>true
   ],
   [
      'attribute'=>'sql',
      'hAlign'=>'left',
      'vAlign'=>'middle',
      'width'=>'450px',
      'pageSummary'=>true ,
      //'format' => 'html',
   ],
   [
      'class' => 'yii\grid\ActionColumn',
      'headerOptions' => ['style'=>'width:50px','class'=>'text-center'],
      'header'=>'Acción',
      'contentOptions' => ['class' => 'text-center'],
      //'template' => '{view} {update} {delete} {link}',
      'template' => '{update} {delete}',
      'buttons' => [
         'update'=>function ($url, $model) {
            $url = Url::to(['actualiza-item', 'regn' => $model->regn, 'titulo' => $model->titulo]);
            return Html::button('<span class="glyphicon glyphicon-pencil"></span>',
               ['data-url'=>Url::to($url), 'class' => 'btn btn-default btn-xs botonActItem']);
         },
         'delete' => function ($url, $model) {
            $url = Url::toRoute(['borraitem']);
            return Html::a('', $url, [
               'class'       => 'btn btn-xs glyphicon glyphicon-trash borra-item',
               'data-regn'   => Yii::$app->funcion->cifrar($model->regn,date('d')),
               'data-titulo' => $model->titulo,
               'data-url'    => $url,
            ]);
         },
      ],
   ],
]; //$columnas

Pjax::begin(['id'=>'grillaItems']);
echo GridView::widget([
   'dataProvider' => $datosItems,
   'columns' => $columnas,
   'responsive'=>true,
   'hover'=>true,
   'resizableColumns'=>true,
   'export' => false,  // Asi no hay necesidad de instalar la extensión MPDF
   // 'pjax' => true,
   'rowOptions' => ['class' => GridView::TYPE_ACTIVE]
]);
Pjax::end();
