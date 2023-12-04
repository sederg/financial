<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\RatioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Ratios');
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>
<div class="ratio-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create Ratio'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

         //   'id',
            'ratio',
            'formula',
            'descripcion',
            'valor',
            'criterio',
           
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
