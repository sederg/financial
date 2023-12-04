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
<?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'fecha')->widget(kartik\widgets\DatePicker::className(),[
                                                        'options' => ['placeholder' => 'Entre la fecha ...',
                                                                     'label'=> 'Fecha',
                                                                     'value'=>date("Y-m-d"),
                                                                    ],
                                                                      'pluginOptions' => [
                                                                                         'autoclose'=>true,
                                                                                         'format' => 'yyyy-mm-dd',
                                                                                         'endDate' => date('yyyy-mm-dd'),
                                                                                         ]
                                                                     ]) ?>

 
    <?php
  echo TabularForm::widget([
    'bsVersion' => '4.x',
    'form' => $form,
    'dataProvider' => $dataprovidersaldos,
    'actionColumn'=>false,
           'checkboxColumn'=>false,
    'attributes' => [
                    'nombre' => ['type' => TabularForm::INPUT_STATIC,
                        'label'=> 'Cuenta',
          ],
                    'id' => [   
                            'type' => TabularForm::INPUT_TEXT, 
                            //'widgetClass' => \kartik\widgets\ColorInput::classname()
                            'columnOptions'=>['hidden'=>true]
                            ],
                    'status' => [
                                'label'=> 'Saldo',
                                'type' => TabularForm::INPUT_WIDGET,
                                'widgetClass'=> TouchSpin::className(),
                                'options' =>[
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
                                    
                                          ],
                                ],

    ],
           
    'gridSettings' => [
        'floatHeader' => true,
        'panel' => [
            'heading' => '<i class="fa fa-sort-numeric-asc"></i>  Estado de las cuentas del periodo',
            

        
       
    ]]     
]); ?>

</div>
<div class="saldo-form">


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
