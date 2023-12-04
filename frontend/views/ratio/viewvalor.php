<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ratio */

$this->title = $model->ratio;
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ratio-view">
    <div  align="center" >
        <div class="row">
            
          <div class="col-lg-4 col-4">
          <div class="small-box bg-success-gradient">
              <div class="inner">
                <h3><?=$valor['1']?></h3>

                <p ><?=$periodo['1']?></p>
              </div>
          
          </div>
          </div>
          <div class="col-lg-4 col-4">
          <div class="small-box bg-danger-gradient">
              <div class="inner">
                <h3><?=$valor['2']?></h3>

                <p ><?=$periodo['2']?></p>
              </div>
          
          </div>
          </div>
          <div class="col-lg-4 col-4">
          <div class="small-box bg-danger-gradient">
              <div class="inner">
                <h3><?=$valor['3']?></h3>

                <p ><?=$periodo['3']?></p>
              </div>
          
          </div>
          </div>
        </div>
    </div>
<div class="card card-widget widget-user">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-primary-gradient "align = "center">
                <h3 class="widget-user-desc"><?=$model->ratio ?></h3>
                <h6  class="widget-user-desc" align = "center"><?=$model->concepto ?></h6>
              </div>
              <div class="widget-user-image">
                 
              </div>
              <div class="card-footer">
                <div class="row">
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <span class="description-text"><?=$model->descripcion?></span>
                      <h5 class="description-header"><?=$model->formula?></h5>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4 border-right">
                    <div class="description-block">
                      <!--<h5 class="description-header">13,000</h5>-->
                      <span class="description-text"> <?= Html::encode($model->valor)?> </span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                  <div class="col-sm-4">
                    <div class="description-block">
                      <h5 class="description-header"></h5>
                      <span class="description-text"><?=$model->criterio?></span>
                    </div>
                    <!-- /.description-block -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
            </div>
   

    <?php DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'ratio',
            'formula',
            'descripcion',
            'valor',
            'criterio',
        ],
    ]) ?>

</div>
