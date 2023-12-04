<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\User */

$this->title = Yii::t('app', 'Cambiar Contraseña de: {name}', [
    'name' => $model->username,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Usuarios'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->username]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Cambiar Contraseña');
$this->params['tittle'][]= $this->title;
?>
<div class="user-update">

    

    <?= $this->render('_pass', [
        'model' => $model,
    ]) ?>

</div>
