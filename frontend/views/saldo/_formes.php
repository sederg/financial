<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use kartik\touchspin\TouchSpin;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model frontend\models\Indicadoresgestion */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indicadoresgestion-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="row"  >  
        
  
        <div class="col-lg-4">
  <?php echo Select2::widget([
    'name' => 'Mes',
    'data' =>  [
                1 => 'enero', 
                2 => 'febrero',
              3 => 'marzo', 
                4 => 'abril',
              5 => 'mayo', 
                6 => 'junio',
              7 => 'julio', 
                8 => 'agosto',
              9 => 'septiembre', 
                10 => 'octubre',
              11 => 'noviembre', 
                12 => 'diciembre',
              ],
    'options' => ['placeholder' => 'Seleciona el mes a mostrar ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]); ?>
</div>

   
    </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Selecionar'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
