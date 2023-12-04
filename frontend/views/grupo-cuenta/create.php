<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\GrupoCuenta */

$this->title = Yii::t('app', 'Crear Grupo de Cuenta');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Grupo de Cuentas'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['tittle'][] = $this->title;
?>
<div class="grupo-cuenta-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
