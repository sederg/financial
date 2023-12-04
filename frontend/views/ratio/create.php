<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ratio */

$this->title = Yii::t('app', 'Crear Ratio');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ratios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>
<div class="ratio-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
