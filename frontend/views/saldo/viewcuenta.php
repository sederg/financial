<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\Saldo */

$this->title = $model->cuenta->nombre;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estado de las cuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="saldo-view">

  

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'cuenta.nombre',
            [
                
            'attribute'=>'saldo',
                'format'=>'currency'
            ],
            'fecha',
            [
              'attribute'=>'empresa.nombre',
               'label'=>'Empresa',
             
            ],
        ],
    ]) ?>

</div>
