<?php

namespace app\models;

use Yii;

/**
* This is the model class for table "plantilla".
*
* @property string $regn
* @property string $nombreplantilla
*/
class Plantillas extends \yii\db\ActiveRecord
{

	public static function tableName()
	{
		return 'plantillas';
	}

	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
			[['nombreplantilla'], 'string', 'max' => 100],
		];
	}

	/**
	* @inheritdoc
	*/
	public function attributeLabels()
	{
		return [
			'regn' => 'Regn',
			'nombreplantilla' => 'Nombre de la Plantilla',
		];
	}

	public function traerCapitulosItems($regn)
	{
		$sql = <<<SQ
			SELECT l.regn AS reglistacap, it.regn AS regitems, c.nombrecapitulo, it.titulo FROM plantillas p
			 LEFT JOIN capitulos c ON c.extregnplantilla=p.regn
			 LEFT JOIN itemsgraficos it ON c.extregnitemsg=it.regn
			 LEFT JOIN listacapitulos l ON l.nombrecapitulo=c.nombrecapitulo
		  WHERE p.regn = :regn
		  ORDER BY ordencapitulos,ordenitems
SQ;
		$cmd = \Yii::$app->db->createCommand($sql);
		$cmd->bindValue(':regn', $regn);
		return $cmd->queryAll();
	}
}
