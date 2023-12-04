<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Empresa */

$this->title = Yii::t('app', 'Actualizar Empresa: {name}', [
    'name' => $model->nombre,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Empresas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actualizar');
$this->params['tittle'][] = $this->title;
?>
<div class="empresa-update">
</h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
