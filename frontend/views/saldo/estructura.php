<?php

use yii\helpers\Html;
use yii\bootstrap\ButtonDropdown;
use miloschuman\highcharts\Highcharts;
use yii\helpers\Url;
use yii\bootstrap4\Alert;
use kartik\popover\PopoverX;
use kartik\widgets\Select2;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\EvaluacionCuadroSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Análisis Gráfico de la Estructura de las cuentas');
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>


<div class="evaluacion-cuadro-index">
    
<?php if(Yii::$app->session->hasFlash("no_datos")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-error'], 'body' => "Los datos correspondientes a este periodo no han sido introducidos. Se mostraron del datos correspondientes al periodo(". $_SESSION['periodo'].").Para ver los de este periodo, primero deben ser insertados."]);
        ?>
    <?php endif; ?>     
    </div>
    

   

<div>

      <hr>
    <p>
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
$form = ActiveForm::begin(['fieldConfig'=>['showLabels'=>false],'action'=>Yii::$app->urlManager->createUrl(['saldo/selecionarmes','fecha'=>$fecha,'act'=>'2']), 'options' => ['id'=>'kv-login-form']]);
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
    </p>
    <hr>

    <div style="display: none"> 
                    <?php
                      echo Highcharts::widget([
                          
                           'scripts' => [
                               'highcharts-more', 
                              // 'modules/drilldown'
                           ]
                          ]);
                      ?>
         </div>

    <div class="body-content">

        <div class="row">
            
            <div class="col-lg-6 col col-sm-6">
               <p>
                   <div id = "chart1" > </div>
               </p>                
            </div>
            
            <div class="col-lg-6 col-sm-6">
               <p>
                   <div id = "chart2" > </div>
               </p>                
            </div>
                     
        </div>
        
     </div>  
         
    <div class="body-content">

        <div class="row">
            
            <div class="col-lg-6 col-sm-6">
               <p>
                   <div id = "chart3" > </div>
               </p>                
            </div>
            
<!--            <div class="col-lg-6 col-sm-6">
               <p>
                   <div id = "chart4" > </div>
               </p>                
            </div>-->
                     
        </div>
        
     </div>  
         

     <?php
   //$sql = 'SELECT DISTINCT componentes.nombre as componente,(SELECT COUNT(control.evaluacionid) FROM control,subnorma, norma WHERE control.evaluacionid = 2 AND control.status = 1 and control.periodo = '.$periodo.' and subnorma.evaluado = 1 and norma.Componentesid= componentes.id AND control.subnormaid = subnorma.id AND subnorma.normaid = norma.id AND control.entidadid = '.\frontend\controllers\UserController::findModel(Yii::$app->user->getId())->entidad->id.')as no,(SELECT COUNT(control.evaluacionid) FROM control, subnorma, norma WHERE control.evaluacionid = 1 AND control.status = 1  and control.periodo = '.$periodo.' and subnorma.evaluado = 1 and norma.Componentesid=componentes.id AND control.subnormaid = subnorma.id AND subnorma.normaid = norma.id AND control.entidadid = '.\frontend\controllers\UserController::findModel(Yii::$app->user->getId())->entidad->id.')as si FROM control,subnorma,componentes,norma WHERE control.subnormaid = subnorma.id AND subnorma.normaid = norma.id AND componentes.id = norma.Componentesid AND norma.status = 1';
   //$rawData = Yii::$app->db->createCommand($sql)->queryAll();
   $rawData = $saldoPatrimonioA;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_PA[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalPA = json_encode($total_PA);   
    
   }
   }
   else
   {
      $totalPA = "false"; 
     // $no_total = "false"; 
   }
   $rawData = $saldoActivoF;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_AF[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalAF = json_encode($total_AF);   
    
   }
   }
   else
   {
      $totalAF = "false"; 
     // $no_total = "false"; 
   }
   $rawData = $saldoActivoC;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_AC[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalAC = json_encode($total_AC);   
    
   }
   }
   else
   {
      $totalAC = "false"; 
     // $no_total = "false"; 
   }
   $rawData = $saldoActivoLP;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_ALP[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalALP = json_encode($total_ALP);   
    
   }
   }
   else
   {
      $totalALP = "false"; 
     // $no_total = "false"; 
   }
   $rawData = $saldoActivoD;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_AD[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalAD = json_encode($total_AD);   
    
   }
   }
   else
   {
      $totalAD = "false"; 
     // $no_total = "false"; 
   }
  
   $rawData = $saldoActivoO;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_AO[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalAO = json_encode($total_AO);   
    
   }
   }
   else
   {
      $totalAO = "false"; 
     // $no_total = "false"; 
   }
  
   $rawDatap = $saldoPasivoA;
   if($rawDatap)
   {
   $total_datap = [];
   foreach ($rawDatap as $data)
   { 
      $total_CA[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalCA = json_encode($total_CA);   
    
   }
   }
   else
   {
      $totalCA = "false"; 
     // $no_total = "false"; 
   }
  
   ?>

<?php $this->registerJs("$(function(){
      $('#chart1').highcharts({
      chart: {
          type: 'column',
          options3d:{
                    enabled: true,
                    alpha: 15,
                    beta: 15,
                    viewDistance: 25,
                    depth: 40
            }
          },
      title: { 
         text: 'Estructura del Pasivo + Capital' 
         },
      xAxis: {
                categories:['$periodo','$periodoant'],
                
                labels:{
                        overflow:'justify'
                        }
              },
      yAxis:{
             min: 0,
             title:{
                text: '%'
              }
            },
            tooltip:{
                    pointFormat:'<b>{series.name}:</b>{point.y}<br/>',
                    shared:true
                },
            plotOptions:{
              
                    series: {
            borderWidth: 0,
            dataLabels: {
               enabled: true,
        
               }  
         }
                },
         series:[{
                name:'Total del Patrimonio',
                data: $totalPA
                },{
                name:'Total del Pasivo',
                data: $totalCA
                }]
                }); });
");
 $this->registerJs("$(function(){
      $('#chart2').highcharts({
      chart: {
          type: 'column',
          options3d:{
                    enabled: true,
                    alpha: 15,
                    beta: 15,
                    viewDistance: 25,
                    depth: 40
            }
          },
      title: { 
         text: 'Estructura del Activo' 
         },
      xAxis: {
                categories:['$periodo','$periodoant'],
                
                labels:{
                        overflow:'justify'
                        }
              },
      yAxis:{
             min: 0,
             title:{
                text: '%'
              }
            },
            tooltip:{
                    pointFormat:'{series.name}:<b>{point.y}</b> ({point.percentage: of}%)<br/>',
                    shared:true
                },
            plotOptions:{
                column:{
                        stacking: 'percent',
                          dataLabels: {
                         
               enabled: true
               }
                       
                    },
                     
                },
         series:[{
                name:'Activos Fijos',
                data: $totalAF
                },{
                name:'Activos Circulantes',
                data: $totalAC
                },{
                name:'Activos Diferidos',
                data: $totalAD
                },{
                name:'Activos a Largo Plazo',
                data: $totalALP
                },{
                name:'Otros Activos',
                data: $totalAO
                }]
                }); });
");
?>

    
    
</div>  
 