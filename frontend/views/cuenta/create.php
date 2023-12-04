<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Cuenta */

$this->title = Yii::t('app', 'Create Cuenta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Cuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>
<div class="cuenta-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
