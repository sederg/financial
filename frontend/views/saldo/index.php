<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SaldoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Estado de cuentas');
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>
<div class="saldo-index">

 
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
            'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="fa fa-sort-numeric-asc"></i> Grupos de Cuentas</h3>',
        'type'=>'primary',
        // 'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Agregar ', ['value'=>Url::to('index.php?r=mesa/create'),'class' => 'btn btn-success','id'=>'modalButton']),
        'before'=>Html::a('<i class="fa fa-plus"></i> Crear estado de Cuenta', ['create'], ['class' => 'btn btn-success','id'=>'agregar']),
        //'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
        //'footer'=>false
    ],
        'export'=>false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',return
            [
              'attribute'=>'fechas',
                'label'=>'Fecha',
                'value'=>function($model)
                {
                    return $model->fecha;
                },
               'group'=>true,
                /* 'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(frontend\models\Saldo::find()->orderBy('id')->asArray()->all(), 'id', 'fecha'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Selecione la fecha'],
                'group'=>true,  // enable grouping
             */
            ],
            [
              'attribute'=>'cuentaid',
                'value'=>function($model){ 
                return $model->cuenta->nombre;
                },
                 'label'=>'Nombre de Cuenta',
                 'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(frontend\models\Cuenta::find()->orderBy('id')->asArray()->all(), 'id', 'nombre'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Selecione la fecha'],
                'group'=>true,  // enable grouping
             
            ],
            
            [
              'attribute'=>'saldo',
               'format'=>'currency',
            ],
           
   ['class' => 'yii\grid\ActionColumn','template'=>'{update}{delete}',
                   'buttons' => [
                      'update' => function ($url, $model){
                                                            return Html::a('<i class="fa fa-edit"></i>', 
                                                                      ['update','id' => $model->id],
                                                                      
                                                                      ['class' => 'btn btn-success btn-xs',
                                                                        'title' => 'Actualizar' ,
                                                                          
                                                                          'style'=>'margin-left:10px',
                                                                          ]);    
                                                           }, 

                                   'view' => function ($url, $model){
                                                            return Html::a('<i class="fa fa-eye"></i>', 
                                                                      ['viewcuenta','id' => $model->id],
                                                                      
                                                                      ['class' => 'btn btn-info btn-xs',
                                                                        'title' => 'Ver ' ,
                                                                          ]);    
                                                           },
                                   'delete' => function ($url, $model){
               
                   return Html::a('<i class="fa fa-trash-o"></i>', 
                                                                      ['delete','id' => $model->id],
                                                                      
                                                                      ['class' => 'btn btn-danger btn-xs',
                                                                        'title' => 'Eliminar' ,
                                                                          'style'=>'margin-left:10px',
                                                                          //'disabled'=>'disabled'
                                                                          ]);    
                  
                                
                
                
                          },
        ],],

 

        ],
    ]); ?>


</div>
