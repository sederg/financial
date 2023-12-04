<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\builder\TabularForm;
use kartik\touchspin\TouchSpin;

/* @var $this yii\web\View */
/* @var $model frontend\models\Saldo */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="saldo-form">
   <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'saldo')->widget(TouchSpin::className(),[
          
             'options' =>[
                            'class'=>'input-sm',
                            'placeholder'=>'0',
                          ],
             'pluginOptions' => [
                                 'class'=>'input-xs',
                                                        'prefix'=>'$',
                                                        'initval'=>1.00,
                                                        'decimals'=>2,
                                                        'min'=>0,
                                                        'max'=>20000000,
                                                        'step'=>0.01,
                                                        'buttonup_class'=>'btn btn-primary',
                                                        'buttondown_class'=>'btn btn-info',
                                                        'buttonup_txt'=>'<i class="fa fa-plus"></i>',
                                                        'buttondown_txt'=>'<i class="fa fa-minus"></i>',    
                                                   ]
         ]);?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Actualizar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>
</div>
