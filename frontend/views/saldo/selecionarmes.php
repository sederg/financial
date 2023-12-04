<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Evaluacion */

$this->title = Yii::t('app', 'seleccionar mes');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'seleccionar mes'), 'url' => ['criteriomedida/llenar']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][]= $this->title;
?>
<div class="evaluacion-create">

   
    <?= $this->render('_formes') ?>

</div>
