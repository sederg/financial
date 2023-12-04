<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ratio */

$this->title = Yii::t('app', 'Actualizar Ratio: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ratios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
$this->params['tittle'][] = Yii::t('app', 'Actualizar');
?>
<div class="ratio-update">

    
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
