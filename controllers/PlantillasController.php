<?php

namespace app\controllers;

use
Yii,
yii\data\ActiveDataProvider,
yii\web\Controller,
app\models\Plantillas;

class PlantillasController extends Controller
{
   public function actionPlantillas()
   {
      /* Trae todos los itemsgraficos */
      $datosPlantillas = new ActiveDataProvider([
         'query' => Plantillas::find()->indexBy('regn'),
         'sort' => ['defaultOrder' => ['nombreplantilla' => SORT_ASC]],
         'pagination' => ['pageSize' => 20]]
      );

      return $this->render('plantillas', ['datosPlantillas' => $datosPlantillas]);
   }

   /**
   * Viene del boton modal crea item
   */
   public function actionCreaPlantilla() {
      $model = new Plantillas();

      $rq = Yii::$app->request;
      if ($rq->post('Plantillas') !== null) {
         $model->attributes = $rq->post('Plantillas');
         $model->fechag = date('Y-m-d H:i:s');
         if ($model->validate()) {
            if ($model->save()) {
               return $this->redirect('plantillas');
            } else {
               echo 0;
            }
         } else {
            // validation failed: $errors is an array containing error messages
            $errors = $model->errors;
            return $this->render('/site/errors', ['errors' => $errors, 'modulo' => 'en creación de ciclos']);
         }
      } else {
         return $this->renderAjax('formPlantilla', ['model' => $model, 'modo' => 'C']);
      }
   }

   /**
   * Borra plantilla, acción viene de gridview
   */
   public function actionBorraPlantilla() {
      if (Yii::$app->request->post('regn') !== null) {
         $regn = Yii::$app->funcion->descifrar(Yii::$app->request->post('regn'), date('d'));
         Plantillas::deleteAll('regn = :regn', [':regn' => $regn]);
         return $this->redirect('plantillas');
      }  else {
         echo 0;//json_encode(['estado' => 'failed']);
      }
   }

   /**
   * Actualiza plantilla
   */
   public function actionActualizaPlantilla($regn = 0) {
      $model = Plantillas::find()->where('regn = :regn', [':regn' => $regn])->one();

      $rq = Yii::$app->request;
      if ($rq->post('Plantillas') !== null) {
         $model->attributes = $rq->post('Plantillas');
         if ($model->validate()) {
            $model->save();
            return $this->redirect('plantillas');
         } else {
            // validation failed: $errors is an array containing error messages
            $errors = $model->errors;
            return $this->render('/site/errors', ['errors' => $errors, 'modulo' => 'en actualización de plantilla']);
         }
      } else
         return $this->renderAjax('formPlantilla', ['model' => $model, 'modo' => 'A']);
   }



}
