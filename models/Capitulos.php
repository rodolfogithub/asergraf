<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "capitulos".
 *
 * @property string $regn
 * @property integer $ordencapitulos
 * @property integer $ordenitems
 * @property string $nombrecapitulo
 * @property string $extregnplantilla
 * @property string $extregnitemsg
 * @property string $activo
 * @property string $fechag
 * @property string $usuariog
 * @property string $fecham
 * @property string $usuariom
 */
class Capitulos extends \yii\db\ActiveRecord
{
	 /**
	  * @inheritdoc
	  */
	 public static function tableName()
	 {
		  return 'capitulos';
	 }

	 /**
	  * @inheritdoc
	  */
	 public function rules()
	 {
		  return [
				[['ordencapitulos', 'ordenitems', 'extregnplantilla', 'extregnitemsg', 'nombrecapitulo', 'activo'], 'required'],
				[['ordencapitulos', 'ordenitems', 'extregnplantilla', 'extregnitemsg'], 'integer'],
				[['fechag', 'fecham'], 'safe'],
				[['nombrecapitulo'], 'string', 'max' => 100],
				[['activo'], 'string', 'max' => 1],
				[['usuariog', 'usuariom'], 'string', 'max' => 50],
		  ];
	 }

}
