<?php
use yii\bootstrap4\Alert;

$this->title = 'Razones financieras';
$this->params['tittle'][] = $this->title;
?>
<div class="razones">
        <?php if(Yii::$app->session->hasFlash("no_datos")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-error'], 'body' => "Los datos correspondientes a este periodo no han sido introducidos. Se mostraron del datos correspondientes al periodo(". $_SESSION['periodo'].").Para ver los de este periodo, primero deben ser insertados."]);
        ?>
    <?php endif; ?> 


    
    <div class="col-lg-12">
            <div class="card card-danger">
              <div class="card-header">
                  <h3 class="card-title"><strong>Liquidez:</strong> Posibilidad de hacer frente a sus pagos a corto plazo. (<?=$periodo?>) </h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$liquidez?></h3>

                <p>Liquidez General (pesos)</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>1,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$liquidezim?></h3>

                <p>Liquidez Inmediata</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>2,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=$disp?></h3>

                <p>Disponibilidad</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>3,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
           
        </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
    </div>
     <div class="col-lg-12">
            <div class="card card-danger">
              <div class="card-header">
                  <h3 class="card-title"><strong>Actividad:</strong>  Mide el grado de efectividad con que la empresa utiliza sus recursos.  (<?=$periodo?>) </h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$ciclocobros?> días. </h3>

                <p>Ciclo de Cobros</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>4,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$ciclopagos?> días.</h3>

                <p>Ciclo de pagos</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>5,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=$cicloinventarios?> días.</h3>

                <p>Ciclo de inventarios</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>6,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
           
        </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
     </div>
       <div class="col-lg-12">
            <div class="card card-danger">
              <div class="card-header">
                  <h3 class="card-title"><strong> Endeudamiento: </strong> Diagnostica sobre la estructura, cantidad y calidad de la deuda de la empresa. (<?=$periodo?>) </h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?=$endeudamiento?></h3>

                <p>Endeudamiento(%)</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>7,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3><?=$autonomia?></h3>

                <p>Autonomía (%)</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>8,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3><?=$calidaddeuda?></h3>

                <p>Calidad de la Deuda (%)</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>9,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
           
        </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
       </div>
    <div class="row">
    <div class="col-lg-6">
            <div class="card card-danger">
              <div class="card-header">
                  <h3 class="card-title"><strong> Solvencia: </strong>  Diagnostica como puedes cubrir todas sus deudas con los activos reales que posee. (<?=$periodo?>)</h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
          <div class="col-lg-12 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $solvencia?></h3>

                <p>Solvencia (pesos) </p>
             
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>10,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
       </div>
    <div class="col-lg-6">
            <div class="card card-danger">
              <div class="card-header">
                  <h3 class="card-title"><strong> Rentabilidad: </strong>  Mide el rendimiento sobre los capitales invertidos.  (<?=$periodo?>) </h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
          <div class="col-lg-12 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3><?= $rentabilidad?></h3>

                <p>Margen sobre ventas  o Rentabilidad Económica (%)</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
              <a href="<?= Yii::$app->urlManager->createUrl(['ratio/viewvalor','id'=>11,'fecha'=>$fecha,'periodo'=>$periodo])?>" class="small-box-footer">Detalles <i class="fa fa-arrow-circle-right"></i></a>
            </div>
          </div>
        
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
       </div>
    </div>
    

</div>