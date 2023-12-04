<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "cuenta".
 *
 * @property int $id
 * @property string $nombre
 * @property int $grupo_cuentaid
 * @property string $status
 *
 * @property GrupoCuenta $grupoCuenta
 * @property Saldo[] $saldos
 */
class Cuenta extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cuenta';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'grupo_cuentaid'], 'required'],
            [['grupo_cuentaid'], 'integer'],
            [['nombre'], 'string', 'max' => 255],
            [['grupo_cuentaid'], 'exist', 'skipOnError' => true, 'targetClass' => GrupoCuenta::className(), 'targetAttribute' => ['grupo_cuentaid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'nombre' => Yii::t('app', 'Nombre'),
            'grupo_cuentaid' => Yii::t('app', 'Grupo de Cuenta'),
            'status' => Yii::t('app', 'status'),
        ];
    }

    /**
     * Gets query for [[GrupoCuenta]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupoCuenta()
    {
        return $this->hasOne(GrupoCuenta::className(), ['id' => 'grupo_cuentaid']);
    }

    /**
     * Gets query for [[Saldos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSaldos()
    {
        return $this->hasMany(Saldo::className(), ['cuentaid' => 'id']);
    }
}
