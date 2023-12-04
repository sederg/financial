<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;
use kartik\popover\PopoverX;
use kartik\form\ActiveForm;
use yii\bootstrap4\Alert;
use kartik\select2\Select2;





/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SaldoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estado de Situación');
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>
<div class="saldo-index">
     <?php if(Yii::$app->session->hasFlash("no_datos")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-error'], 'body' => "Los datos correspondientes a este periodo no han sido introducidos. Se mostraron del datos correspondientes al periodo(". $_SESSION['periodo'].").Para ver los de este periodo, primero deben ser insertados."]);
        ?>
    <?php endif; ?>      

   <div class="card card-danger">
              <div class="card-header">
                  <h3 class="card-title">Comparar datos con otro periodo </h3>

              </div>
              <!-- /.card-header -->
              <div class="card-body">
              
                    <?php

                            $form = ActiveForm::begin(['fieldConfig'=>['showLabels'=>false],'action'=> Yii::$app->urlManager->createUrl(['saldo/selecionarmes','fecha'=>$fecha,'act'=>'1']), 'options' => ['id'=>'kv-login-form']]);
                            ?> 
                                
                                <div class="row">
                                    <div class="col-lg-5">
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
                            ]);?>
                                    </div>
                                    <div class="col-lg-5">
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
                            ]);?>
                                    </div>
                                    <div class="col-lg-2">
                                       <div class="form-group">
                                    <?= Html::submitButton(Yii::t('app', 'Comparar'), ['class' => 'btn btn-success']) ?>
                                </div>  
                                    </div>
                                </div>
                            <?php

                            ActiveForm::end();

                            ?>
             
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>

   


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
    'dataProvider' => $dataProvider,
   //'filterModel' => $searchModel,
    'showPageSummary' => true,
    'pjax' => true,
    'striped' => true,
    'hover' => true,
    'panel' => ['type' => 'danger', 'heading' => '<i class="fa fa-line-chart"></i> Estado de Situación ('.$mesact.'/'.$annoact.')'],
    'toggleDataContainer' => ['class' => 'btn-group mr-2 me-2'],
    'columns' => [
        ['class' => 'kartik\grid\SerialColumn'],
        
          [
            'attribute' => 'cuenta', 
            'width' => '50px',
            'value' => function ($model, $key, $index, $widget) { 
                return $model->cuenta->grupoCuenta->grupoGeneral->grupo;
            },
//            'filterType' => GridView::FILTER_SELECT2,
//            'filter' => ArrayHelper::map(\frontend\models\GrupoGeneral::find()->orderBy('id')->asArray()->all(), 'id', 'grupo'), 
//            'filterWidgetOptions' => [
//                'pluginOptions' => ['allowClear' => true],
//            ],
//            'filterInputOptions' => ['placeholder' => 'Selecione el grupo '],
            'group' => true,  // enable grouping
            'groupHeader' => function ($model, $key, $index, $widget) { // Closure method
                return [
                    'mergeColumns' => [[1,3]], // columns to merge in summary
                    'content' => [             // content to show in each summary cell
                        1 => 'Total (' . $model->cuenta->grupoCuenta->grupoGeneral->grupo. ')',
                        6 => GridView::F_SUM,
                       4 => GridView::F_SUM,
                      //  8 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        5 => ['format' => 'number', 'decimals' => 2],
                       4=> ['format' => 'number', 'decimals' => 2],
                        6 => ['format' => 'number', 'decimals' => 2],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        1 => ['style' => 'font-variant:small-caps'],
                        5 => ['style' => 'text-align:right'],
                        4 => ['style' => 'text-align:right'],
                        6 => ['style' => 'text-align:right'],
                    ],
                    // html attributes for group summary row
                    'options' => ['class' => 'info table-danger','style' => 'font-weight:bold;']
                ];
            }
        ],
        [
            'attribute' => 'cuentaid', 
            'label' => 'Tipo', 
            'width' => '100px',
            'value' => function ($model, $key, $index, $widget) { 
               return $model->cuenta->grupoCuenta->grupo;
               // return $model->cuenta->nombre;
            },
//            'filterType' => GridView::FILTER_SELECT2,
//            'filter' => ArrayHelper::map(frontend\models\GrupoCuenta::find()->orderBy('grupo_generalid')->asArray()->all(), 'id', 'grupo'), 
//            'filterWidgetOptions' => [
//                'pluginOptions' => ['allowClear' => true],
//            ],
//            'filterInputOptions' => ['placeholder' => 'El tipo de cuenta'],
            'group' => true,  // enable grouping
            'subGroupOf' => 1 ,// supplier column index is the parent group,
            'groupFooter' => function ($model, $key, $index, $widget) { // Closure method
                return [
                     'mergeColumns' => [[2, 3]], // columns to merge in summary
                    'content' => [              // content to show in each summary cell
                        2 => 'Total (' . $model->cuenta->grupoCuenta->grupo . ')',
                        6 => GridView::F_SUM,
                        4 => GridView::F_SUM,
                      //  8 => GridView::F_SUM,
                    ],
                    'contentFormats' => [      // content reformatting for each summary cell
                        5 => ['format' => 'number', 'decimals' => 2],
                        4 => ['format' => 'number', 'decimals' => 2],
                        6 => ['format' => 'number', 'decimals' => 2],
                    ],
                    'contentOptions' => [      // content html attributes for each summary cell
                        5 => ['style' => 'text-align:right'],
                        4 => ['style' => 'text-align:right'],
                        6 => ['style' => 'text-align:right'],
                    ],
                    // html attributes for group summary row
                    'options' => ['class' => 'success table-info','style' => 'font-weight:bold;']
                ];
            },
        ],
      
       
        [
            'attribute' => 'Concepto',
            'value'=>'cuenta.nombre',
            'width' => '450px',
            'hAlign' => 'right',
           'pageSummary' => 'Total General',
           'pageSummaryOptions' => ['class' => 'text-right text-end'],
        ],
        [
            'attribute' => 'saldo',
            'label'=>'Saldo ('.$mesact.'/'.$annoact.')',
            'width' => '150px',
            'hAlign' => 'right',
            'format' => ['decimal', 2],
            'pageSummary' => true,
            'pageSummaryFunc' => GridView::F_SUM
        ],
        [
            'class' => '\kartik\grid\FormulaColumn',
             'header' => '%',
            
            'value' => function ($model, $key, $index, $widget) {
            $p = compact('model', 'key', 'index');
            // Write your formula below
            if(frontend\controllers\SaldoController::percent($model)==0)
            {
                return 0;
            }else{
                
            return $widget->col(4, $p) / frontend\controllers\SaldoController::percent($model);
            }
            },
          
            'width' => '50px',
            'hAlign' => 'right',
            'format' => ['percent', 2],
           // 'pageSummary' => true,
        //    'pageSummaryFunc' => GridView::F_SUM,
        ],
        [
            'attribute' => $mes != null ? ('Saldo ('. frontend\controllers\SaldoController::meses($mes).'/'.$anno.')'):'Saldo Periodo Anterior',
            'class' => '\kartik\grid\FormulaColumn',
            'value'=>function ($model) { 
              
              $saldo = frontend\controllers\SaldoController::compararperido($model->id,$model->status);
                return $saldo ? $saldo->saldo:0.0;
                return $model->status;
                
            },
            'width' => '150px',
            'hAlign' => 'right',
            'format' => ['decimal', 2],
            'pageSummary' => true,
            'pageSummaryFunc' => GridView::F_SUM,
        ],
         [
            'class' => '\kartik\grid\FormulaColumn',
            'header' => '%',
            'value' => function ($model, $key, $index, $widget) {
            $p = compact('model', 'key', 'index');
           if(frontend\controllers\SaldoController::percent($model)==0)
           {return 0;}
           else{
               
            return $widget->col(6, $p)/ frontend\controllers\SaldoController::percent($model);
           }
            },
          
            'width' => '50px',
            'hAlign' => 'right',
            'format' => ['percent', 2],
           
        ],
         [
            'class' => '\kartik\grid\FormulaColumn',
            'header' => 'Variación Absoluta',
            'value' => function ($model, $key, $index, $widget) {
            $p = compact('model', 'key', 'index');
           
            return $widget->col(6, $p) - $widget->col(4, $p);
            },
          'pageSummary' => true,
            'pageSummaryFunc' => GridView::F_SUM,
            'width' => '50px',
            'hAlign' => 'right',
            'format' => ['decimal', 2],
           
        ],
         [
            'class' => '\kartik\grid\FormulaColumn',
            'header' => 'Variación Relativa',
            'value' => function ($model, $key, $index, $widget) {
            $p = compact('model', 'key', 'index');
            if($widget->col(4, $p)==0)
            {
              return 0;  
            }else{
               return $widget->col(6, $p)/ $widget->col(4, $p); 
            }
            
            },
          'pageSummary' => true,
            'pageSummaryFunc' => GridView::F_SUM,
            'width' => '50px',
            'hAlign' => 'right',
            'format' => ['percent', 2],
           
        ],

    ],
]);
            ?>

</div>
