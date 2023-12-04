<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "saldo".
 *
 * @property int $id
 * @property string $fecha
 * @property string $saldo
 * @property int $empresaid
 * @property int $cuentaid
 *
 * @property Cuenta $cuenta
 * @property Empresa $empresa
 */
class Saldo extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'saldo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha', 'empresaid', 'cuentaid'], 'required'],
            [['fecha'], 'safe'],
            [['saldo'], 'string'],
            [['empresaid', 'cuentaid'], 'integer'],
            [['cuentaid'], 'exist', 'skipOnError' => true, 'targetClass' => Cuenta::className(), 'targetAttribute' => ['cuentaid' => 'id']],
            [['empresaid'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['empresaid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'fecha' => Yii::t('app', 'Fecha'),
            'empresaid' => Yii::t('app', 'Empresaid'),
            'cuentaid' => Yii::t('app', 'Cuentaid'),
        ];
    }

    /**
     * Gets query for [[Cuenta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCuenta()
    {
        return $this->hasOne(Cuenta::className(), ['id' => 'cuentaid']);
    }

    /**
     * Gets query for [[Empresa]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'empresaid']);
    }
}
