<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "ratio".
 *
 * @property int $id
 * @property string|null $ratio
 * @property string|null $concepto
 * @property string|null $formula
 * @property string $descripcion
 * @property string $valor
 * @property string $criterio
 */
class Ratio extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ratio';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'valor', 'criterio','ratio',], 'required'],
            [['ratio', 'formula', 'valor'], 'string', 'max' => 255],
            [['descripcion', 'concepto','criterio'], 'string', 'max' => 500],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ratio' => Yii::t('app', 'Ratio'),
            'formula' => Yii::t('app', 'Formula'),
            'descripcion' => Yii::t('app', 'Descripcion'),
            'valor' => Yii::t('app', 'Valor'),
            'criterio' => Yii::t('app', 'Criterio'),
            'concepto' => Yii::t('app', 'Concepto'),
        ];
    }
}
