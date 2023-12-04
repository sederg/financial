<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'Crear Usuario');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][]= $this->title;
?>
<div class="user-create">

</div>
    
     <?php
     
     if(\Yii::$app->user->isGuest||\Yii::$app->user->identity->rolid == 4)
     {
       echo $this->render('_formS', [
             'model' => $model,
            'trabajador' => $trabajador,
       
    ]); 
     }else{
         echo $this->render('_form', [
             'model' => $model,
            'trabajador' => $trabajador,
       
    ]);
     }
         ?>

</div>
