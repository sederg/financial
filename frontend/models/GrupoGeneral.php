<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "grupo_general".
 *
 * @property string $id
 * @property string $grupo
 * @property string $status
 *
 * @property GrupoCuenta[] $grupoCuentas
 */
class GrupoGeneral extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupo_general';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'grupo'], 'required'],
            [['id', 'grupo'], 'string', 'max' => 255],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'grupo' => Yii::t('app', 'Grupo'),
            'status' => Yii::t('app', 'status'),
        ];
    }

    /**
     * Gets query for [[GrupoCuentas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoCuentas()
    {
        return $this->hasMany(GrupoCuenta::className(), ['grupo_generalid' => 'id']);
    }
}
