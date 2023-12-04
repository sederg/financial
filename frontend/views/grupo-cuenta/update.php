<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\GrupoCuenta */

$this->title = Yii::t('app', 'Update Grupo Cuenta: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Grupo Cuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="grupo-cuenta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
