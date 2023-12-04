<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Ratio */

$this->title = $model->ratio;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Ratios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="ratio-view">

   

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            'ratio',
            'formula',
            'descripcion',
            'concepto',
            'valor',
            'criterio',
        ],
    ]) ?>

</div>
