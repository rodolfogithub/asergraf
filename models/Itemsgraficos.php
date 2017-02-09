<?php

namespace app\models;

use Yii;

/**
* This is the model class for table "itemsgraficos".
*
* @property string $regn
* @property string $titulo
* @property string $nomgrafico
* @property string $sql
* @property string $fechag
* @property string $fecham
* @property string $usuariog
* @property string $usuariom
* @property string $activo
*/
class Itemsgraficos extends \yii\db\ActiveRecord
{
	/**
	* @inheritdoc
	*/
	public static function tableName()
	{
		return 'itemsgraficos';
	}

	/**
	* @inheritdoc
	*/
	public function rules()
	{
		return [
			[['titulo', 'nomgrafico', 'sql', 'fechag'], 'required'],
			[['sql'], 'string'],
			[['fechag', 'fecham'], 'safe'],
			[['titulo'], 'string', 'max' => 100],
			[['nomgrafico', 'usuariog', 'usuariom'], 'string', 'max' => 50],
			[['activo'], 'string', 'max' => 1],
		];
	}

	/**
	* @inheritdoc
   */
	public function attributeLabels()
	{
		return [
			'regn' => 'Regn',
			'titulo' => 'Titulo',
			'nomgrafico' => 'Nombre del gráfico',
			'sql' => 'Instrucción SQL',
			'fechag' => 'Fechag',
			'fecham' => 'Fecham',
			'usuariog' => 'Usuariog',
			'usuariom' => 'Usuariom',
			'activo' => 'Activo',
		];
	}


	public function traerGraficos()
	{
		$sql = <<<SQ
		  SELECT p.nombreplantilla, c.nombrecapitulo, it.titulo, it.sql FROM plantilla p
			 LEFT JOIN capitulos c ON c.extregnplantilla=p.regn
			 LEFT JOIN itemsgraficos it ON c.extregnitemsg=it.regn
		  WHERE p.regn=(SELECT extplantilla FROM clienteplantilla WHERE nit='8001417701') AND it.sql <> ''
		  ORDER BY nombrecapitulo,titulo
SQ;
		$cmd = \Yii::$app->db->createCommand($sql);
		return $cmd->queryAll();
	}


	public function traeDatosSQL($sql)
	{
		Yii::$app->db->createCommand("SET lc_time_names = 'es_ES';")->execute();
		$cmd = \Yii::$app->db->createCommand($sql);
		return $cmd->queryAll();
	}


}
