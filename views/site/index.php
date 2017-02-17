
<?php

/* @var $this yii\web\View */

$this->title = 'Gráficos estadísticos';

echo yii\helpers\Html::a('<span class="glyphicon glyphicon-sunglasses"><span style="font-family: Helvetica; font-size: 1.5em">&nbsp;Gráfico',
	['/graficos']).'<br><br>';

echo yii\helpers\Html::a('<span class="glyphicon glyphicon-sunglasses"><span style="font-family: Helvetica; font-size: 1.5em">&nbsp;Crear Items',
   ['/itemsgraficos/items']).'<br><br>';

echo yii\helpers\Html::a('<span class="glyphicon glyphicon-sunglasses"><span style="font-family: Helvetica; font-size: 1.5em">&nbsp;Crear Plantillas',
   ['/plantillas/grilla-plantillas']).'<br><br>';

?>
