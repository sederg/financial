<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "trabajador".
 *
 * @property string $nombre
 * @property string $primerApellido
 * @property string $segundoApellido
 * @property string $telefono
 * @property int $CI
 * @property string $email
 * @property int $id
 * @property int $iduser
 *
 * @property User $user
 */
class Trabajador extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'trabajador';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'primerApellido', 'segundoApellido', 'CI', 'email'], 'required'],
            [['CI'],'string', 'max'=>11],
            [['CI'],'string', 'min'=>11],
            ['CI', 'ValidarCI'],
            [['nombre', 'primerApellido', 'segundoApellido', 'email'], 'string', 'max' => 255],
            [['telefono'], 'string', 'max' => 12],
            //[['iduser'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['iduser' => 'id']],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email', 'message' => 'Formato no válido'],
             ['email', 'unique', 'targetClass' => '\frontend\models\trabajador', 'message' => 'Este email ya fue registrado por otro usuario.'],
           
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'nombre' => Yii::t('app', 'Nombre'),
            'primerApellido' => Yii::t('app', 'Primer Apellido'),
            'segundoApellido' => Yii::t('app', 'Segundo Apellido'),
            'telefono' => Yii::t('app', 'Telefono'),
            'CI' => Yii::t('app', 'Número de Identidad'),
            'email' => Yii::t('app', 'Correo Electronico'),
            'id' => Yii::t('app', 'ID'),
            'iduser' => Yii::t('app', 'Usuario'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'iduser']);
    }
     public function ValidarCI() 
    {
        $valido = FALSE;
        $ci = $this->CI;
      // $t = strlen(ci);        
     if(strlen($ci) == 11 )
     { 
       $mes = substr($ci,2,2);
       $dia = substr($ci,4,2);
       if($mes == 02)
       {
           if($dia < 29 && $dia > 00)
           {
             $valido = TRUE;  
           }
       }
       else{
           if($mes >00 && $mes < 13)
            {
               if($dia <= 31 && $dia > 00)
                   $valido = TRUE;
            }
            else{
                $valido = FALSE;
            }
       }
                 
     }
    
     if($valido == FALSE)
     {
         $this->addError('CI', 'El Número de identidad no es valido, por favor verifiquelo');
     }
   }
}
