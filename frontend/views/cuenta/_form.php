<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cuenta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cuenta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

   
      <?= $form->field($model, 'grupo_cuentaid')->widget(Select2::className(),[
        'data'=> ArrayHelper::map(\frontend\models\GrupoCuenta::find()->where(['status'=>1])->all(), 'id', 'grupo'),
         'pluginOptions'=>['placeholder'=>'Selecione el tipo de Cuenta...'],
                  
    ]);?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
