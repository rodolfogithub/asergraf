<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "listacapitulos".
 *
 * @property string $regn
 * @property string $nombrecapitulo
 * @property string $fechag
 * @property string $usuariog
 * @property string $fecham
 * @property string $usuariom
 * @property string $activo
 */
class Listacapitulos extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'listacapitulos';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fechag', 'fecham'], 'safe'],
            [['nombrecapitulo'], 'string', 'max' => 40],
            [['usuariog', 'usuariom'], 'string', 'max' => 50],
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
            'nombrecapitulo' => 'Nombre Capitulo',
            'fechag' => 'Fechag',
            'usuariog' => 'Usuariog',
            'fecham' => 'Fecham',
            'usuariom' => 'Usuariom',
            'activo' => 'Activo',
        ];
    }
}
