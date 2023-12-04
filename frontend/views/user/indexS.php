<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Alert;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Usuarios');
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][]= $this->title;
?>
<div class="user-index">

  
    <?php
    //Se activa si se registra una actualización en el AreasController.
     if(Yii::$app->session->hasFlash("ok_contraseña")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-success'], 'body' => "La contraseña del usuario ". $_SESSION['user']. " ha sido cambiada con exito. "]);
        ?>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash("usuario_propio")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-danger'], 'body' => "Usted no puede bloquear su propio usuario. "]);
        ?>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash("ok_activado")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-success'], 'body' => "El usuario ". $_SESSION['user']. " ha sido desbloqueado satisfactoriamente. "]);
        ?>
    <?php endif; ?>
    <?php if(Yii::$app->session->hasFlash("ok_desactivado")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-info'], 'body' => "El usuario ". $_SESSION['user']. " ha sido bloqueado satisfactoriamente. "]);
        ?>
    <?php endif; ?>
        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

       <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'panel' => [
        'heading'=>'<h3 class="panel-title"><i class="fa fa-user-circle-o"></i> Usuarios</h3>',
        'type'=>'primary',
        
        // 'before'=>Html::button('<i class="glyphicon glyphicon-plus"></i> Agregar ', ['value'=>Url::to('index.php?r=mesa/create'),'class' => 'btn btn-success','id'=>'modalButton']),
        'before'=>Html::a('<i class="fa fa-user-plus"></i> Agregar', ['create'], ['class' => 'btn btn-success','id'=>'agregar']),
        //'after'=>Html::a('<i class="glyphicon glyphicon-repeat"></i> Reset Grid', ['index'], ['class' => 'btn btn-info']),
        //'footer'=>false
    ],
          'export'=>false, 
        /*'toolbar'=>[
        '{toggleData}'
    ],*/
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
            'attribute'=>'username',
            'label' => 'Nombre de Usuario',
            
            ],
            [
             'attribute'=>'entidadid',
            'label' => 'Empresa',   
            'value'=> function ($model){
            return $model->entidad->nombre;
            },
             'filterType'=>GridView::FILTER_SELECT2,
                'filter'=>ArrayHelper::map(frontend\models\Entidad::find()->where(['status'=>1])->orderBy('id')->asArray()->all(), 'id', 'nombre'), 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                'filterInputOptions'=>['placeholder'=>'Selecione la Empresa'],
            
                ],
            [
            'attribute'=>'status',
            'label' => 'Estado',
             'format'=>'raw',
            'value'=>  function ($model){
             return             $model->status ==10 ? '<i class="glyphicon glyphicon-ok" style="color:green"></i>' :'<i class="glyphicon glyphicon-remove" style="color:red"></i>' ;
            },
                       'filterType'=>GridView::FILTER_SELECT2,   
                       'filter'=>[
                           0=>'Bloqueado',
                           10=>'Desbloqueado    ',
                       ], 
                'filterWidgetOptions'=>[
                    'pluginOptions'=>['allowClear'=>true],
                ],
                 'filterInputOptions'=>['placeholder'=>'Estado'],
                
            ],
           
            ['class' => 'yii\grid\ActionColumn',
              'template' => '{view} {password} {Activar}',
                 'buttons' => [
                     'password' => function ($url, $model){

                                                          
                                                              return Html::a('<i class="glyphicon glyphicon-lock"></i>', 
                                                                      ['password','id'=>$model->id],
                                                                      
                                                                      ['class' => 'btn btn-primary btn-xs',
                                                                        'title' => 'Cambiar Contraseña'  
                                                                          ]);
                                                          
                                      
              
                          },
                                  'Activar' => function ($url, $model){
               
                if( $model->status ==10){
                    
                     return Html::a('<i class="glyphicon glyphicon-remove"></i>', 
                                                                      ['desactivar','id'=>$model->id],
                                                                      
                                                                      ['class' => 'btn btn-danger btn-xs',
                                                                        'title' => 'Desactivar Usuario'  
                                                                          ]);
                                                          
                    
                  
                            }else{
                                 return Html::a('<i class="glyphicon glyphicon-ok"></i>', 
                                                                      ['activar','id'=>$model->id],
                                                                      
                                                                      ['class' => 'btn btn-success btn-xs',
                                                                        'title' => 'Activar Usuario'  
                                                                          ]);
                    
                
                            }        
                
                
                          },
                                     'view' => function ($url, $model){
                                                          
                                                              return Html::a('<i class="fa fa-eye"></i>', 
                                                                      ['view','id'=>$model->id],
                                                                      
                                                                      ['class' => 'btn btn-info btn-xs',
                                                                        'title' => 'Ver',
                                                                         // 'style'=>"margin-left: 10px"
                                                                          ]);
                                                          
                                                           }, 
                ],
        ],
                                  ],
    ]); 
      ?>
</div>
