<?php

namespace app\controllers;

use
Yii,
yii\data\ActiveDataProvider,
yii\web\Controller,
app\models\Itemsgraficos;

class ItemsgraficosController extends Controller
{
   public function actionItems()
   {
      $traeDatos = Itemsgraficos::traerGraficos();

      /* Trae todos los itemsgraficos */
      $datosItems = new ActiveDataProvider([
         'query' => Itemsgraficos::find()->indexBy('regn'),
         'sort' => ['defaultOrder' => ['titulo' => SORT_ASC]],
         'pagination' => ['pageSize' => 20]]
      );

      return $this->render('itemsgraficos', ['datosItems' => $datosItems]);
   }

   /**
   * Viene del boton modal crea item
   */
   public function actionCreaItem() {
      $model = new Itemsgraficos();

      $rq = Yii::$app->request;
      if ($rq->post('Itemsgraficos') !== null) {
         $model->attributes = $rq->post('Itemsgraficos');
         $model->fechag = date('Y-m-d H:i:s');
         if ($model->validate()) {
            if ($model->save()) {
               return $this->redirect('items');
            } else {
               echo 0;
            }
         } else {
            // validation failed: $errors is an array containing error messages
            $errors = $model->errors;
            return $this->render('/site/errors', ['errors' => $errors, 'modulo' => 'en creación de ciclos']);
         }
      } else {
         return $this->renderAjax('formItems', ['model' => $model, 'modo' => 'C']);
      }
   }

   /**
   * Borra item, acción viene de gridview
   */
   public function actionBorraitem() {
      if (Yii::$app->request->post('regn') !== null) {
         $regn = Yii::$app->funcion->descifrar(Yii::$app->request->post('regn'), date('d'));
         Itemsgraficos::deleteAll('regn = :regn', [':regn' => $regn]);
         return $this->redirect('items');
      }  else {
         echo 0;//json_encode(['estado' => 'failed']);
      }
   }

   /**
   * Actualiza item
   */
   public function actionActualizaItem($regn = 0) {
      $model = Itemsgraficos::find()->where('regn = :regn', [':regn' => $regn])->one();

      $rq = Yii::$app->request;
      if ($rq->post('Itemsgraficos') !== null) {
         $model->attributes = $rq->post('Itemsgraficos');
         if ($model->validate()) {
            $model->save();
            return $this->redirect('items');
         } else {
            // validation failed: $errors is an array containing error messages
            $errors = $model->errors;
            return $this->render('/site/errors', ['errors' => $errors, 'modulo' => 'en actualización de item']);
         }
      } else
         return $this->renderAjax('formItems', ['model' => $model, 'modo' => 'A']);
   }



}
