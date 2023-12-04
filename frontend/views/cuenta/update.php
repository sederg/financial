<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cuenta */

$this->title = Yii::t('app', 'Actualizar Cuenta: {name}', [
    'name' => $model->grupoCuenta->grupo,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Actulalizar');
$this->params['tittle'][] = Yii::t('app', 'Update');
?>
<div class="cuenta-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
