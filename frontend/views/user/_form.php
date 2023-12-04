<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\widgets\MaskedInput;
use frontend\models\Rol;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form kartik\form\ActiveForm; */
?>


<div class="usuarios-form">

    <?php $form = ActiveForm::begin(['enableAjaxValidation'=>TRUE]); ?>
 <?php if(Yii::$app->session->hasFlash("error_validacion")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-danger'], 'body' => "Erros al Crear el Usuario, Vuelva a intentarlo "]);
        ?>
     <?php endif; ?>
    <hr>
    <br>
    <table align = "center">                     
        <tr>          
               <td style="padding-left: 0px">
                  <?= $form->field($trabajador, 'nombre',[
                                                        'feedbackIcon' => [
                                                            'default' => 'text-size',
                                                            'success' => 'ok',
                                                            'error' => 'exclamation-sign',
                                                            'defaultOptions' => ['class'=>'text-primary']
                                                        ]
                                                    ])->textInput(['maxlength' => 20,'style' => 'width:300px']) ?>
               </td>      
             
             <td style="padding-left: 100px">
                  <?= $form->field($trabajador, 'primerApellido',[
                                                        'feedbackIcon' => [
                                                            'default' => 'text-size',
                                                            'success' => 'ok',
                                                            'error' => 'exclamation-sign',
                                                            'defaultOptions' => ['class'=>'text-primary']]
                                                        ])->textInput(['maxlength' => 35,'style' => 'width:300px']) ?>
             </td>       
           </tr>    
        <tr>          
               <td style="padding-left: 0px">
                  <?= $form->field($trabajador, 'segundoApellido',[
                                                        'feedbackIcon' => [
                                                            'default' => 'text-size',
                                                            'success' => 'ok',
                                                            'error' => 'exclamation-sign',
                                                            'defaultOptions' => ['class'=>'text-primary']
                                                        ]])->textInput(['maxlength' => 20,'style' => 'width:300px']) ?>
               </td>      
             
             <td style="padding-left: 100px">
                 <?= $form->field($trabajador, 'CI',[
                                                        'feedbackIcon' => [
                                                            'default' => 'credit-card',
                                                            'success' => 'ok',
                                                            'error' => 'exclamation-sign',
                                                            'defaultOptions' => ['class'=>'text-primary']
                                                        ]])->textInput(['maxlength' => 11,'style' => 'width:300px']) ?>
           
             </td>       
           </tr> 
           
        
       
        
        <tr>          
               <td style="padding-left: 0px">
                          <?= $form->field($trabajador, 'telefono',[
                                                        'feedbackIcon' => [
                                                            'default' => 'phone',
                                                            'success' => 'ok',
                                                            'error' => 'exclamation-sign',
                                                            'defaultOptions' => ['class'=>'text-primary']]
                                                        ])->widget(MaskedInput::className()
                    ,[
             'mask'=>'999-999-9999'   
            ]) ?>
        </div>
                  
               </td>      
             
             <td style="padding-left: 100px">
                 <?= $form->field($trabajador, 'email',[
                                                        'feedbackIcon' => [
                                                            'default' => 'envelope',
                                                            'success' => 'ok',
                                                            'error' => 'exclamation-sign',
                                                            'defaultOptions' => ['class'=>'text-primary']
                                                        ]])->textInput(['maxlength' =>120 ,'style' => 'width:300px']) ?>
                 
             </td>       
           </tr>           
           <tr>
               <td style="padding-left: 0px">
                 
                           <?= $form->field($model, 'username',[
                                                        'feedbackIcon' => [
                                                            'default' => 'user',
                                                            'success' => 'ok',
                                                            'error' => 'exclamation-sign',
                                                            'defaultOptions' => ['class'=>'text-primary']
                                                        ]])->textInput(['maxlength' => 35,'style' => 'width:300px']) ?>
             </td>               
               <td style="padding-left: 100px">
                  
                      <?= $form->field($model, 'rolid')->widget(kartik\select2\Select2::className(),[
                        'data'=> yii\helpers\ArrayHelper::map(Rol::find()->where('id!=1')->andwhere('id!=4')->andwhere('id!=5')->all(), 'id', 'rol'),
                        'pluginOptions'=>['placeholder'=>'Selecione la funcion de usuario'],
                    ])->label('Tipo de Usuario')?>  
               </td> 
           </tr>
          
           
           <tr>
               <td style="padding-left: 0px">
                  <?= $form->field($model, 'password_hash',[
                                                        'feedbackIcon' => [
                                                            'default' => 'option-horizontal',
                                                            'success' => 'ok',
                                                            'error' => 'exclamation-sign',
                                                            'defaultOptions' => ['class'=>'text-primary']
]                                                        ])->passwordInput(['maxlength' => 250,'style' => 'width:300px']) ?>
               </td>         
               <td style="padding-left: 100px">
                  <?= $form->field($model, "password_repeat",[
                                                        'feedbackIcon' => [
                                                            'default' => 'option-horizontal',
                                                            'success' => 'ok',
                                                            'error' => 'exclamation-sign',
                                                            'defaultOptions' => ['class'=>'text-primary']
                                                        ]])->passwordInput(['maxlength' => 250,'style' => 'width:300px']) ?>
               </td>
             <tr>
               <td colspan="2">
             <?=                          
                     $form->field($model, 'entidadid')->widget(kartik\select2\Select2::className(),[
                    'data'=> yii\helpers\ArrayHelper::map(frontend\models\Empresa::find()->where(['id'=>\frontend\controllers\UserController::findModel(Yii::$app->user->getId())->entidad->id])->all(), 'id', 'nombre'),
                    'pluginOptions'=>['placeholder'=>'Selecione la empresa  del usuario..'
                        
                        ],
                         
                    ])?>
                   
               </td>
           </tr>
           </tr>
    </table>

    <div class="form-group" align = "center" style="padding-left: 5px">
        <br>
        <?= Html::submitButton($model->isNewRecord ? 'Insertar' : 'Guardar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-success','id'=>'guardar']) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>