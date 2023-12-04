<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\GrupoCuentaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Grupo de Cuentas');
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>
<div class="grupo-cuenta-index">

   

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
         'dataProvider' => $dataProvider,

        'filterModel' => $searchModel,
        'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="fa fa-sort-numeric-asc"></i> Grupos de Cuentas</h3>',
        'type'=>'primary',
        // 'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Agregar ', ['value'=>Url::to('index.php?r=mesa/create'),'class' => 'btn btn-success','id'=>'modalButton']),
        'before'=>Html::a('<i class="fa fa-plus"></i> Agregar', ['create'], ['class' => 'btn btn-success','id'=>'agregar']),
        //'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
        //'footer'=>false
    ],
        'export'=>false,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            'grupo',
           // 'status',
            'grupoGeneral.grupo',
           
   ['class' => 'yii\grid\ActionColumn','template'=>'{view}{update}{delete}',
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
                                                                      ['view','id' => $model->id],
                                                                      
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
                                                                        'data' => [
                                                                            'confirm' => 'Are you sure you want to delete this item?',
                                                                            'method' => 'post',
                                                                        ],  ]);    
                  
                                
                
                
                          },
        ],],



        ],
    ]); ?>


</div>
