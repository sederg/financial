<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ratio */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ratio-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'ratio')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'concepto')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'formula')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'valor')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'criterio')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
