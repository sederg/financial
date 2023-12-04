<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "rol".
 *
 * @property int $id
 * @property string $rol
 *
 * @property User[] $users
 */
class Rol extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['rol'], 'required'],
            [['rol'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'rol' => Yii::t('app', 'Rol'),
        ];
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['rolid' => 'id']);
    }
}
