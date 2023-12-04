<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Saldo */

$this->title = Yii::t('app', 'Actualizar estado de cuenta : {name} - del periodo ({periodo})', [
    'name' => $model->cuenta->nombre,
    'periodo'=>$model->fecha,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estado de  cuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['Ver', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>
<div class="saldo-update">

 
    <?= $this->render('_formupd', [
        'model' => $model,
    ]) ?>

</div>
