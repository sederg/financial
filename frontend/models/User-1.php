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
 * @property int $rolid
 * @property int $entidadid
 * @property int $trabajadorid
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $verification_token
 *
 * @property Empresa $entidad
 * @property Rol $rol
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
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
            [['username', 'auth_key', 'password_hash', 'email', 'rolid', 'entidadid', 'trabajadorid', 'created_at', 'updated_at'], 'required'],
            [['rolid', 'entidadid', 'trabajadorid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['entidadid'], 'exist', 'skipOnError' => true, 'targetClass' => Empresa::className(), 'targetAttribute' => ['entidadid' => 'id']],
            [['rolid'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['rolid' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'email' => Yii::t('app', 'Email'),
            'rolid' => Yii::t('app', 'Rolid'),
            'entidadid' => Yii::t('app', 'Entidadid'),
            'trabajadorid' => Yii::t('app', 'Trabajadorid'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'verification_token' => Yii::t('app', 'Verification Token'),
        ];
    }

    /**
     * Gets query for [[Entidad]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getEntidad()
    {
        return $this->hasOne(Empresa::className(), ['id' => 'entidadid']);
    }

    /**
     * Gets query for [[Rol]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'rolid']);
    }
}
