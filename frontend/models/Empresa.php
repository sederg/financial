<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "empresa".
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $nombre_corto
 * @property string $direccion
 * @property string $email
 * @property string $telefono
 * @property int $provinciaid
 * @property int $status
 *
 * @property Provincia $provincia
 * @property Saldo[] $saldos
 * @property User[] $users
 */
class Empresa extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'empresa';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'direccion', 'email', 'telefono', 'provinciaid'], 'required'],
            [['provinciaid', 'status'], 'integer'],
            [['nombre', 'nombre_corto', 'direccion', 'email'], 'string', 'max' => 255],
            [['telefono'], 'string', 'max' => 20],
            [['provinciaid'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['provinciaid' => 'id']],
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
            'nombre_corto' => Yii::t('app', 'Nombre Corto'),
            'direccion' => Yii::t('app', 'Direccion'),
            'email' => Yii::t('app', 'Email'),
            'telefono' => Yii::t('app', 'Telefono'),
            'provinciaid' => Yii::t('app', 'Provinciaid'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * Gets query for [[Provincia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProvincia()
    {
        return $this->hasOne(Provincia::className(), ['id' => 'provinciaid']);
    }

    /**
     * Gets query for [[Saldos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSaldos()
    {
        return $this->hasMany(Saldo::className(), ['empresaid' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['entidadid' => 'id']);
    }
}
