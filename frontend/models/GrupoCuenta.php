<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "grupo_cuenta".
 *
 * @property int $id
 * @property string $grupo
 * @property int $status
 * @property string $grupo_generalid
 *
 * @property Cuenta[] $cuentas
 * @property GrupoGeneral $grupoGeneral
 */
class GrupoCuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupo_cuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['grupo', 'grupo_generalid'], 'required'],
            [['status'], 'integer'],
            [['grupo', 'grupo_generalid'], 'string', 'max' => 255],
            [['grupo_generalid'], 'exist', 'skipOnError' => true, 'targetClass' => GrupoGeneral::className(), 'targetAttribute' => ['grupo_generalid' => 'id']],
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
            'status' => Yii::t('app', 'Status'),
            'grupo_generalid' => Yii::t('app', 'Grupo General'),
        ];
    }

    /**
     * Gets query for [[Cuentas]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuentas()
    {
        return $this->hasMany(Cuenta::className(), ['grupo_cuentaid' => 'id']);
    }

    /**
     * Gets query for [[GrupoGeneral]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoGeneral()
    {
        return $this->hasOne(GrupoGeneral::className(), ['id' => 'grupo_generalid']);
    }
}
