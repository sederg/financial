<?php


use yii\helpers\Html;
use kartik\widgets\ActiveForm;


use backend\models\Rol;


/* @var $this yii\web\View */
/* @var $model app\models\Usuarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <hr>
    <br>
    <table align = "center">                     
       
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
         </tr>
         <tr>
               <td style="padding-left: 0px">
                  <?= $form->field($model, "password_repeat",[
                                                        'feedbackIcon' => [
                                                            'default' => 'option-horizontal',
                                                            'success' => 'ok',
                                                            'error' => 'exclamation-sign',
                                                            'defaultOptions' => ['class'=>'text-primary']
]                                                        ])->passwordInput(['maxlength' => 250,'style' => 'width:300px']) ?>
               </td>
           </tr>
          
           
       
    </table>

    <div class="form-group" align = "center" style="padding-left: 5px">
        <br>
        <?= Html::submitButton( 'Cambiar', ['class' => 'btn btn-success' ]) ?>
        <?= Html::a('Cancelar', ['index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>