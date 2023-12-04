<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


/* @var $this yii\web\View */
/* @var $model frontend\models\Empresa */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Empresas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="empresa-view">


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'nombre',
            'nombre_corto',
            'direccion',
            'email:email',
            'telefono',
            'provincia.provincia',
         //   'status',
        ],
    ]) ?>

</div>
