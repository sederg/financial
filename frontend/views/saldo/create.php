<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\Saldo */

$this->title = Yii::t('app', 'Crear Estado de Cuentas');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Estado de Cuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>
<div class="saldo-create">

    <?= $this->render('_form', [
        'model' => $model,
        'dataprovidersaldos'=>$dataprovidersaldos,
    ]) ?>

</div>
