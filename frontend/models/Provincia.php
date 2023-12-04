<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "provincia".
 *
 * @property int $id
 * @property string $provincia
 *
 * @property Empresa[] $empresas
 */
class Provincia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'provincia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['provincia'], 'required'],
            [['provincia'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'provincia' => Yii::t('app', 'Provincia'),
        ];
    }

    /**
     * Gets query for [[Empresas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresas()
    {
        return $this->hasMany(Empresa::className(), ['provinciaid' => 'id']);
    }
}
