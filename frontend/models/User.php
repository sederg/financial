<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $password_reset_token
 * @property string $email
 * @property int|null $trabajadorid
 * @property int $entidadid
 * @property int|null $rolid
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $last_login
 *
 * @proper$entidadty Rol $rol
 * @property Empresa $entidad
 * @property Trabajador $trabajador
 * @property Trabajador[] $trabajadors
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     * 
     */
    public $password_repeat;
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email', 'created_at', 'updated_at'], 'required'],
            [['trabajadorid', 'rolid', 'status', 'created_at', 'updated_at', 'last_login','entidadid'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['rolId'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['rolId' => 'id']],
            [['trabajadorid'], 'exist', 'skipOnError' => true, 'targetClass' => Trabajador::className(), 'targetAttribute' => ['trabajadorid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Usuario'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Contraseña'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'trabajadorid' => Yii::t('app', 'Trabajador'),
            'password_repaet' => Yii::t('app', 'Repetir Contraseña'),
            'rolid' => Yii::t('app', 'Tipo de Usuario'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'last_login' => Yii::t('app', 'Last Login'),
        ];
    }

    /**
     * Gets query for [[Rol]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'rolId']);
    }

    /**
     * Gets query for [[Trabajador]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajador()
    {
        return $this->hasOne(Trabajador::className(), ['id' => 'trabajadorid']);
    }
    public function getEntidad()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'entidadid']);
    }

    /**
     * Gets query for [[Trabajadors]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTrabajadors()
    {
        return $this->hasMany(Trabajador::className(), ['iduser' => 'id']);
    }
}
