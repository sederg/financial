<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Empresa */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="empresa-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row">
        <div class="col-lg-4">
            
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-2">
            
        <?= $form->field($model, 'nombre_corto')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-6">
            
            <?= $form->field($model, 'direccion')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            
    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            
    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-lg-4">
            
    <?= $form->field($model, 'provinciaid')->widget(kartik\select2\Select2::className(),[
        
             'data'=> yii\helpers\ArrayHelper::map(\frontend\models\Provincia::find()->all(), 'id', 'provincia'),   
            'pluginOptions'=>['placeholder'=>'Selecione la provincia'],
                   
                ]) ?>
        </div>
    </div>
        








    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Guardar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
