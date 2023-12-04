<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model frontend\models\GrupoCuenta */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grupo-cuenta-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'grupo')->textInput(['maxlength' => true]) ?>

  

    <?= $form->field($model, 'grupo_generalid')->widget(Select2::className(),[
        'data'=> ArrayHelper::map(\frontend\models\GrupoGeneral::find()->where(['status'=>1])->all(), 'id', 'grupo'),
         'pluginOptions'=>['placeholder'=>'Selecione el grupo de la cuenta...'],
                  
    ]);?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
