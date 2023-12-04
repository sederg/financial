<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use kartik\popover\PopoverX;
use yii\helpers\Url;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EvaluacionCuadroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Análisis Gráfico de la Estructura de las cuentas');
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>


<div class="evaluacion-cuadro-index">
    
    <table border="1" class="panel panel-info kv-grid-table table table-bordered table-striped kv-table-wrap">
        <thead>
            <tr class="bg-primary-gradient">
                <th class="info"colspan="3"><center><h3 >Estado de Resultado Consolidado(Periodo: <?=$periodo?>) </h3></center>
                </th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                     <?php  PopoverX::begin([
    'placement' => PopoverX::ALIGN_AUTO,
    'toggleButton' => ['label'=>'<i class="fa fa-calendar-plus-o"></i> Comparar ', 'class'=>'btn btn-success'],
    'header' => '<i class="fa fa-calendar"></i> Comparar con otro periodo',
    'footer' => Html::button('<i class="fa fa-check"></i>', [
            'class' => 'btn btn-sm btn-primary', 
            'onclick' => '$("#kv-login-form").trigger("submit")',
           'value'=> Url::to(['evaluacion/selecionarmes'])
        ]) 
]);
// form with an id used for action buttons in footer
$form = ActiveForm::begin(['fieldConfig'=>['showLabels'=>false],'action'=>Yii::$app->urlManager->createUrl(['saldo/selecionarmes','fecha'=>$fecha,'act'=>'5']), 'options' => ['id'=>'kv-login-form']]);
 echo Select2::widget([
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
    'options' => ['placeholder' => 'Seleciona el mes a comparar ...'],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>
 
        <br>
        
 <?php echo \kartik\touchspin\TouchSpin::widget([
    'name' => 'Año',
          
             'options' =>[
                            'class'=>'input-sm',
                            //'placeholder'=>'2019',
                          ],
             'pluginOptions' => [
                                    'prefix'=>'Año :',
                                    'initval'=> date('Y'),
                                    'min'=>2018,
                                    'max'=>2050,
                                    'step'=>1,
                                    'buttonup_class'=>'btn btn-primary',
                                    'buttondown_class'=>'btn btn-info',
                                    'buttonup_txt'=>'<i class="fa fa-plus"></i>',
                                    'buttondown_txt'=>'<i class="fa fa-minus"></i>',    
        
    ]      
]);
//echo $form->field($model, 'password')->passwordInput(['placeholder'=>'Enter password...']);
ActiveForm::end();
PopoverX::end();
?>
                    
                </td>
                <td class="bg-success-gradient">
                    <h5>
                        
                        <?= $periodo?>
                    </h5>
                </td>
                <td class="bg-danger-gradient">
                    <h5>
                        
                    <?= $periodoant?>
                    </h5>
                </td>
            </tr>
                <?php
                
                foreach($datos as $key=>$dato)
                {
                 ?>   
            <tr>
                <td>
                    <?=$key?>
                </td>
                <td>
                    <?php 
                   
                     echo Yii::$app->formatter->format($dato['saldo'],['currency']);   
                  
                    
                    ?>
                </td>
                <td>
                    
                    <?php
                    
                    echo Yii::$app->formatter->format(\frontend\controllers\SaldoController::agregardatos($datosant, $key),['currency']);
                    ?>
                </td>
            </tr>
                <?php
                if($dato['id']==43)
                {
                  ?> 
            <tr class="bg-warning-gradient">
                <td> <strong>Ventas netas</strong></td>
                <td><strong>
                    <?= Yii::$app->formatter->format(\frontend\controllers\SaldoController::saldoventanetas($mes,$anno,$idempresa), ['currency'])  ?>
                </strong></td>
                
                <td><strong>
                    <?= Yii::$app->formatter->format(\frontend\controllers\SaldoController::saldoventanetas($fechaant['mes'],$fechaant['anno'],$idempresa), ['currency'])  ?>
                </strong></td>
                
            </tr>
            
                      <?php                
                }
                if($dato['id']==45)
                {
                  ?> 
            <tr class="bg-warning-gradient">
                <td> <strong>Utilidad o Pérdida  Bruta en Ventas</strong></td>
                <td><strong>
                    <?= Yii::$app->formatter->format(\frontend\controllers\SaldoController::UPBV($anno,$mes,$idempresa), ['currency']) ?>
               </strong> </td>
                <td><strong>
                    <?= Yii::$app->formatter->format(\frontend\controllers\SaldoController::UPBV($fechaant['anno'],$fechaant['mes'],$idempresa), ['currency']) ?>
               </strong> </td>
                
            </tr>
            
                      <?php                
                }
                if($dato['id']==46)
                {
                  ?> 
            <tr class="bg-warning-gradient">
                <td> <strong>Utilidad o Perdida  Netas  en Ventas</strong></td>
               <td><strong>
                    <?= Yii::$app->formatter->format(\frontend\controllers\SaldoController::UPNV($anno,$mes,$idempresa), ['currency']) ?>
               </strong> </td>
              
               <td><strong>
                    <?= Yii::$app->formatter->format(\frontend\controllers\SaldoController::UPNV($fechaant['anno'],$fechaant['mes'],$idempresa), ['currency']) ?>
               </strong> </td>
              
            </tr>
            
                      <?php                
                }
                if($dato['id']==49)
                {
                  ?> 
            <tr class="bg-warning-gradient">
                <td> <strong>Utilidad o Pérdida  en Operaciones</strong></td>
                <td><strong>
                    
                      <?= Yii::$app->formatter->format(\frontend\controllers\SaldoController::UPO($anno,$mes,$idempresa), ['currency']) ?>
                    </strong>
                </td>
                <td><strong>
                    
                      <?= Yii::$app->formatter->format(\frontend\controllers\SaldoController::UPO($fechaant['anno'],$fechaant['mes'],$idempresa), ['currency']) ?>
                    </strong>
                </td>
               
            </tr>
            
                      <?php                
                }
                if($dato['id']==60)
                {
                  ?> 
            <tr class="bg-warning-gradient">
                <td> <strong>Utilidad del Periodo</strong></td>
                <td>
                    <strong>
                        
                    <?= Yii::$app->formatter->format(\frontend\controllers\SaldoController::UtilidadPeriodo($anno,$mes,$idempresa), ['currency']) ?>
                    </strong>
                </td>
                <td>
                    <strong>
                        
                    <?= Yii::$app->formatter->format(\frontend\controllers\SaldoController::UtilidadPeriodo($fechaant['anno'],$fechaant['mes'],$idempresa), ['currency']) ?>
                    </strong>
                </td>
               
            </tr>
            <tr class="bg-warning-gradient">
                <td> <strong>Reservas para Contingencias</strong></td>
                <td><strong>
                    <?=Yii::$app->formatter->format(\frontend\controllers\SaldoController::reserva($anno,$mes,$idempresa), ['currency'])?>
                   
                    </strong>
                   
                </td>
                <td><strong>
                    <?=Yii::$app->formatter->format(\frontend\controllers\SaldoController::reserva($fechaant['anno'],$fechaant['mes'],$idempresa), ['currency'])?>
                   
                    </strong>
                   
                </td>
               
            </tr>
            <tr class="bg-warning-gradient">
                <td> <strong>Impuesto Sobre Utilidades</strong></td>
                <td><strong>
                    <?=Yii::$app->formatter->format(\frontend\controllers\SaldoController::UsI($anno,$mes,$idempresa), ['currency'])?>
                    
                    </strong>
                </td>
                <td><strong>
                    <?=Yii::$app->formatter->format(\frontend\controllers\SaldoController::UsI($fechaant['anno'],$fechaant['mes'],$idempresa), ['currency'])?>
                    
                    </strong>
                </td>
               
            </tr>
            <tr class="bg-warning-gradient">
                <td> <strong>Utilidad después de Impuesto</strong></td>
                <td><strong>
                    
                    <?=Yii::$app->formatter->format(\frontend\controllers\SaldoController::UdI($anno,$mes,$idempresa), ['currency'])?>
                 
                    </strong>
                     </td>
                <td><strong>
                    
                    <?=Yii::$app->formatter->format(\frontend\controllers\SaldoController::UdI($fechaant['anno'],$fechaant['mes'],$idempresa), ['currency'])?>
                 
                    </strong>
                     </td>
                
            </tr>
            
                      <?php                
                }
                }
                    
                
                ?>
            <tr>
        </tbody>
    </table>

    
</div>
    

   
