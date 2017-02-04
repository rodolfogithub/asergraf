<?php

namespace app\controllers;

use
Yii,
yii\web\Controller,
app\models\Itemsgraficos;

class GraficosController extends Controller
{
	public $layout = 'graficos';

	public function actionIndex()
	{
		$traeDatos = Itemsgraficos::traerGraficos();

		return $this->render('index',compact('traeDatos'));
	}

}
