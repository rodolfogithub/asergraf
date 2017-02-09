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
}
