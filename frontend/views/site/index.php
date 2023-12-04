<?php
use yii\helpers\Html;
use yii\bootstrap4\Alert;
use deyraka\materialdashboard\widgets\CardStats;
use deyraka\materialdashboard\widgets\CardProduct;
use deyraka\materialdashboard\widgets\CardChart;
use deyraka\materialdashboard\widgets\Card;
use deyraka\materialdashboard\widgets\Progress;
use yii\helpers\Url;
use miloschuman\highcharts\Highcharts; 
$this->title = 'Sistema de analisis económico';

$this->params['tittle'][] = $this->title;
$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;
?>

<div class="site-index">

  

    <div class="body-content">
 <?php if(Yii::$app->session->hasFlash("no_datos")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-error'], 'body' => "Los datos correspondientes a este periodo no han sido introducidos. Se mostraron del datos correspondientes al periodo(". $_SESSION['periodo'].").Para ver los de este periodo, primero deben ser insertados."]);
        ?>
    <?php endif; ?>      
 <?php if(Yii::$app->session->hasFlash("error")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-danger'], 'body' => "No existen datos para mostrar "]);
        ?>
    <?php endif; ?>        
      
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
      
    <?php
    if(Yii::$app->user->isGuest)
    {?>
          <div  align ="center" style="margin-top: 200px;">
                  
                 <img src=<?php echo$baseUrl."/images/analisis_economico.png"?> style="display:inline; horizontal-align: top; height:200px;" />
             </div>
             <div  align ="center">
                 <img src=<?php echo$baseUrl."/images/isde.png"?> style="display:inline; horizontal-align: top; height:50px;" />
                  
             </div>
      <div class="login-box">

            <div class="card-body login-card-body">
                  <div class="social-auth-links text-center mb-3">
                       <?=Html::a('Entrar ', ['/site/login'], ['class'=>'btn btn-block btn-primary'])
                       ?>     
                </div>
             </div>
        </div>
               
       
        <?php
    
    }else{?>
        <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$liquidezim?></h3>

                <p>Liquidez Inmediata</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
                <a href= "<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>2,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$rentabilidad?></h3>

                <p>Rentabilidad</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>11,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?= $solvencia?></h3>

                <p>Solvencia (pesos) </p>
             
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>10,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3><?=$endeudamiento?></h3>

                <p>Endeudamiento</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>7,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles  <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
          <!-- Left col -->
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                  <i class="fa fa-bar-chart mr-1"></i>
                  Estructura de las cuentas (<?=$periodo?>)
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item">
                      <a class="nav-link active" href=<?= Yii::$app->urlManager->createUrl(['saldo/estructura'])?> >Detalles  </a>
                  </li>
<!--                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                  </li>-->
              </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                      style="position: relative; height: 300px;">
                       
                        <div class="col-lg-12 col col-sm-12">
                           <p>
                               <div id = "chart1" > </div>
                           </p>                
                        </div>     
                      
                  </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
                </div>
              </div><!-- /.card-body -->
            </div>
        
          </section>
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                  <i class="fa fa-bar-chart mr-1"></i>
                  Flujo de caja (<?=$periodo?>)
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item">
                      <a class="nav-link active" href=<?= Yii::$app->urlManager->createUrl(['grupo-cuenta/flujocaja'])?> >Detalles  </a>
                  </li>
<!--                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                  </li>-->
              </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                      style="position: relative; height: 300px;">
                       
                        <div class="col-lg-12 col col-sm-12">
                           <p>
                               <div id = "chart2" > </div>
                           </p>                
                        </div>     
                      
                  </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
                </div>
              </div><!-- /.card-body -->
            </div>
          
          </section>
          <section class="col-lg-6 connectedSortable">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                  <i class="fa fa-bar-chart mr-1"></i>
                  Cuadrante de Navegación (<?=$periodo?>)   
                </h3>
                <ul class="nav nav-pills ml-auto p-2">
                  <li class="nav-item">
                      <a class="nav-link active" href=<?= Yii::$app->urlManager->createUrl(['saldo/cuadrante'])?> >Detalles  </a>
                  </li>
<!--                  <li class="nav-item">
                    <a class="nav-link" href="#sales-chart" data-toggle="tab">Donut</a>
                  </li>-->
              </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                      style="position: relative; height: 300px;">
                       
                        <div >
                           <p>
                               <div id = "chart3" > </div>
                           </p>                
                        </div>     
                      
                  </div>
                  <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px;"></div>
                </div>
              </div><!-- /.card-body -->
            </div>
          
          </section>
       
        </div>
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>

          
          
   

    </div>
</div>
  
  <?php $rawDatap = $saldoPasivoA;
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
                categories:[],
                
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
   
  $rawData = $cinventario;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_inv[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalinv = json_encode($total_inv);   
    
   }
   }
   else
   {
      $totalinv = "false"; 
     // $no_total = "false"; 
   }
   $rawData = $ccobro;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_AF[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalcobros = json_encode($total_AF);   
    
   }
   }
   else
   {
      $totalcobros = "false"; 
     // $no_total = "false"; 
   }
   $rawData = $efectivo;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_AC[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalefectivo = json_encode($total_AC);   
    
   }
   }
   else
   {
      $totalefectivo = "false"; 
     // $no_total = "false"; 
   }
   $rawData = $cpago;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_ALP[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalcpago = json_encode($total_ALP);   
    
   }
   }
   else
   {
      $totalcpago = "false"; 
     // $no_total = "false"; 
   }
   $rawData = $ccapital;
   if($rawData)
   {
   $total_data = [];
   foreach ($rawData as $data)
   { 
      $total_AD[] = [
         'name' => $data ['componente'], 
          'y' => $data ['si'] * 1, 
          'drilldown' => $data ['componente']];      
      $totalccapital = json_encode($total_AD);   
    
   }
   }
   else
   {
      $totalccapital = "false"; 
     // $no_total = "false"; 
   }

   ?>
<?php 
$this->registerJs("$(function(){
      $('#chart3').highcharts({
      chart: {
          type: 'scatter',
      
          },
      title: { 
         text: '$cuadrante' 
         },
      
      xAxis: {
              
             title:{
                text: 'PE'
              }
              },
      yAxis:{
           
             title:{
                text: 'PF'
              }
            },
            tooltip:{
                    pointFormat:'{series.name}:<b>Y:{point.y}</b> ,X: <b>{point.x}</b><br/>',
                    shared:true
                },
            plotOptions:{
              
                    series: {
            borderWidth: 0,
            dataLabels: {
               enabled: true
               }  
         }
                },
         series:[{
                name:'$empresa - ($periodo)',
                data: [[$liquidez,$saldoretabilidad]]
                }
                ]
                }); });
");
 
?>

<?php 
 $this->registerJs("$(function(){
      $('#chart2').highcharts({
      chart: {
          type: 'bar',
          options3d:{
                    enabled: true,
                    alpha: 15,
                    beta: 15,
                    viewDistance: 25,
                    depth: 40
            }
          },
      title: { 
         text: 'Ciclo de Conversión de Efectivo' 
         },
      xAxis: {
                categories:['$periodo'],
                
                labels:{
                        overflow:'justify'
                        }
              },
      yAxis:{
             min: 0,
             title:{
                text: 'Dias'
              }
            },
            tooltip:{
                    pointFormat:'{series.name}:<b>{point.y}</b> <br/>',
                    shared:true
                },
            plotOptions:{
               series: {
            borderWidth: 0,
            dataLabels: {
               enabled: true
               }  
         }
                },
         series:[{
                name:'Ciclos de Inventarios',
                data: $totalinv
                },{
                name:'Ciclo de Cobros',
                data: $totalcobros
                },{
                name:'Ciclo de Conversion de efectivo',
                data: $totalefectivo
                },{
                name:'Ciclo de Pagos',
                data: $totalcpago                
                },{
                name:'Capital de Trabajo Necesario',
                data: $totalccapital                }]
                }); });
");  
    }  
?>