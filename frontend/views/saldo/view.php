<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\SaldoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Saldos');
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>
<div class="saldo-index">

   
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'cuenta.nombre',
            'saldo',
            //'id',
            'fecha',
            //'empresaid',
           
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
                                                                          //'disabled'=>'disabled'
                                                                          ]);    
                  
                                
                
                
                          },
        ],],



        ],
    ]); ?>


</div>
