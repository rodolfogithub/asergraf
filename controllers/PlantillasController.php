<?php

namespace app\controllers;

use
Yii,
yii\data\ActiveDataProvider,
yii\filters\VerbFilter,
yii\web\Controller,
app\models\Capitulos,
app\models\Itemsgraficos,
app\models\Listacapitulos,
app\models\Plantillas;

class PlantillasController extends Controller
{
	//public $layout = 'graficos';

	/**
	* @inheritdoc
	*/
	public function behaviors()
	{
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}

	/**
	* @inheritdoc
	*/
	public function actions()
	{
		return [ 'error' => ['class' => 'yii\web\ErrorAction'] ];
	}


	/**
	* Solamente se genera la grilla donde se muestra las plantillas creadas
	*
	*/
	public function actionGrillaPlantillas()
	{
		/* Trae todos los itemsgraficos */
		$datosPlantillas = new ActiveDataProvider([
			'query' => Plantillas::find()->indexBy('regn'),
			'sort' => ['defaultOrder' => ['nombreplantilla' => SORT_ASC]],
			'pagination' => ['pageSize' => 20]]
		);

		return $this->render('grillaPlantillas', ['datosPlantillas' => $datosPlantillas]);
	}

	/**
	* Viene del boton modal crea plantilla
	*/
	public function actionCreaPlantilla()
	{
		$model = new Plantillas();

		$rq = Yii::$app->request;
		if ($rq->post('Plantillas') !== null) {
			$model->attributes = $rq->post('Plantillas');
			$model->fechag = date('Y-m-d H:i:s');
			if ($model->validate()) {
				if ($model->save()) {
					return $this->redirect('grilla-plantillas');
				} else {
					echo 0;
				}
			} else {
				// validation failed: $errors is an array containing error messages
				$errors[0] = [1=>'Al crear plantilla'];
				return $this->render('/site/errors', ['errors' => $errors, 'modulo' => 'en creación de ciclos']);
			}
		} else {
			return $this->renderAjax('formPlantilla', ['model' => $model, 'modo' => 'C']);
		}
	}

	/**
	* Borra plantilla, acción viene de gridview
	*/
	public function actionBorraPlantilla()
	{
		if (Yii::$app->request->get('regn') !== null) {
			$regn = Yii::$app->funcion->descifrar(Yii::$app->request->get('regn'), date('d'));
			Plantillas::deleteAll('regn = :regn', [':regn' => $regn]);
			return Yii::$app->response->redirect(['plantillas/grilla-plantillas']);
		}  else {
			$errors[0] = [1=>'Al borrar plantilla con registro ('.$_GET['regn'].')'];
			return $this->render('/site/errors', ['errors' => $errors, 'modulo' => 'en actualización de item']);
		}
	}

	/**
	* Actualiza plantilla
	*
	* @param mixed $regn
	*/
	public function actionActualizaPlantilla($regn = 0)
	{
		$model = Plantillas::find()->where('regn = :regn', [':regn' => $regn])->one();

		$rq = Yii::$app->request;
		if ($rq->post('Plantillas') !== null) {
			$model->attributes = $rq->post('Plantillas');
			if ($model->validate()) {
				$model->save();
				return $this->redirect('grilla-plantillas');
			} else {
				// validation failed: $errors is an array containing error messages
				$errors = $model->errors;
				return $this->render('/site/errors', ['errors' => $errors, 'modulo' => 'en actualización de plantilla']);
			}
		} else
			return $this->renderAjax('formPlantilla', ['model' => $model, 'modo' => 'A']);
	}

	/**
	* $titulo esta en $_GET definido en grilla de plantilla.
	*
	* @param mixed $titulo
	* @param mixed $regn   encriptado
	*/
	public function actionConfigPlantilla($titulo,$regn)
	{
		$rq = Yii::$app->request;
		$regn = Yii::$app->funcion->descifrar($regn,date('d'));

		$listaCapitulos = Listacapitulos::find()->asArray()->all();
		$listaItems = [];

		if ($rq->post('escogeItems') !== null) {
			$listaItems = Itemsgraficos::find()->select('regn,titulo')->where('titulo LIKE :titulo', [':titulo' => '%'.$rq->post('listaItems').'%'])->asArray()->all();
		}
		//		$listaItems = Itemsgraficos::find()->asArray()->all();
		$contenidoPlantilla = Plantillas::traerCapitulosItems($regn);

		$itemsPlantilla = [];  // Columna número 1 (Soltar aquí) Capítulos e items
		$liscapitulos = [];    // Columna número 2 de capitulos disponibles
		$items = [];           // Columna número 3 de items dispobibles

		foreach ($listaCapitulos as $key=>$value) $liscapitulos[$value['regn'].'-0'] = ['content' => $value['nombrecapitulo']];

		foreach ($listaItems as $key=>$value) $items['I-'.$value['regn']] = ['content' => $value['titulo']];

		// llena datos en la primera columna (Capítulos e items)
		$nomcap = '';
		foreach ($contenidoPlantilla as $key=>$value) {
			if ($nomcap <> $value['nombrecapitulo']) {  // Es capitulo
				$nomcap = $value['nombrecapitulo'];
				$contenido = '<div class="alert-warning"><strong>'.$value['nombrecapitulo'].'</strong></div>';
				$registro = $value['reglistacap'];
				$regItem = 0;
				$liscapitulos[$registro.'-0'] = ['content' => $value['nombrecapitulo'], 'disabled'=>true];
			} else { // Es item
				$contenido = '<div class="alert-info"><strong>'.$value['titulo'].'</strong></div>';
				$registro = 'I';
				$regItem = $value['regitems'];
				if (array_key_exists('I-'.$value['regitems'], $items)) {
					$items['I-'.$value['regitems']] = ['content' => $value['titulo'], 'disabled'=>true];
				}
			}
			$itemsPlantilla[$registro.'-'.$regItem] = ['content' => $contenido];
		}

		// Cuando se da click en el botón grabar cambios
		if ($rq->post('grabaCambios') !== null) {
			$modelCapitulos = new Capitulos();
			$registros = explode(",", $rq->post('kv-conn-1'));

			$regcap = 0;   $ordencapitulos = 0;   $ordenitems = 0;   $datos = [];
			foreach ($registros as $key=>$valor) {
				$capItem = explode("-", $valor);  // $capItem[0]=RegCapitulo, $capItem[1]=RegItem
				if ($regcap <> $capItem[0] && $capItem[0] <> 'I') {
					$regcap = $capItem[0];   $ordencapitulos += 10;   $ordenitems = 0;
				}
				if ($capItem[1]>0) $ordenitems += 10;
				// Se busca el nombre del capitulo
				$nombreCapitulo = Listacapitulos::find()->select('nombrecapitulo')->where('regn = :regn', [':regn' => $regcap])->asArray()->one();

				// Se alimentan los campos de la tabla capitulos
				$modelCapitulos->ordencapitulos = $ordencapitulos;
				$modelCapitulos->ordenitems = $ordenitems;
				$modelCapitulos->nombrecapitulo = $nombreCapitulo['nombrecapitulo'];
				$modelCapitulos->extregnplantilla = $regn;
				$modelCapitulos->extregnitemsg = $capItem[1];
				$modelCapitulos->activo = 'S';
				$modelCapitulos->fecham = date('Y-m-d H:i:s');

				if ($modelCapitulos->validate()) {
					$datos[] = [ $ordencapitulos,$ordenitems,$nombreCapitulo['nombrecapitulo'],$regn,$capItem[1],'S',date('Y-m-d H:i:s') ];
				} else {
					// validation failed: $errors is an array containing error messages
					$errors =  $modelCapitulos->errors;
					return $this->render('/site/errors', ['errors' => $errors, 'modulo' => 'en configurar plantilla']);
				}
			} // foreach

			// se borra todo el conjunto de plantilla, porque se vuelve a grabar a partir del formulario configPlantilla
			Capitulos::deleteAll('extregnplantilla = :regplan', [':regplan' => $regn]);
			// Para varios registros se usa batchInsert, así se evita crear n objetos de Capitulos().
			// Solo se usa un objeto de $modelCapitulos para validar registro por registro.
			yii::$app->db->createCommand()->batchInsert(
				'capitulos',
				['ordencapitulos','ordenitems','nombrecapitulo','extregnplantilla','extregnitemsg','activo','fecham'],$datos
			)->execute();

			return $this->redirect('grilla-plantillas');
		} // $_POST

		$lItems = '';

		return $this->render('configPlantilla', compact('titulo','itemsPlantilla','liscapitulos','items','lItems'));
	}

	public function actionAveriguaItems() {
		$security = new Security();
		$string = Yii::$app->request->post('string');
		$lItems = '';
		if (!is_null($string)) {
			$lItems = $security->generatePasswordHash($string);
		}
		return $this->render('configPlantilla', ['lItems' => $lItems]);
	}

}
