<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\RatioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ratio-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'ratio') ?>

    <?= $form->field($model, 'formula') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'valor') ?>

    <?php // echo $form->field($model, 'criterio') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
