<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap4\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\bootstrap4\Html;
use kartik\form\ActiveForm;

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
  
    <div class="login-box" style="margin-top: 0px;">
  <div class="login-logo">
      
       <?=Html::a('<div  align ="center" style="margin-top: 200px;">
                  
                 <img src=' .Yii::$app->urlManager->baseUrl."/images/analisis_economico.png".' style="display:inline; horizontal-align: top; height:70px;" />
             </div>', ['/site/index'], ['class'=>'nav-link '])?>
    
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
   
      <p class="login-box-msg">Autentiquese para poder entrar</p>

      <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
        <div class="form-group has-feedback">
            <?= $form->field($model, 'username', [
                                                        'addon' => [
                                                                    'prepend' => [
                                                                                 'content' => '<i class="fa fa-user"></i>'
                                                                                 ]
                                                                    ]])->textInput(['autofocus' => true,
                    'placeholder'=>'Usuario'
                    ]) ?>
        </div>
        <div class="form-group has-feedback">
                 

                
                <?= $form->field($model, 'password', [
                                                        'addon' => [
                                                                    'prepend' => [
                                                                                 'content' => '<i class="fa fa-lock"></i>'
                                                                                 ]
                                                                    ]
                                                        ])->passwordInput(['placeholder'=>'Contraseña']);?>

          
        </div>
        <div class="row">
          <div class="col-8">
         
          </div>
          <!-- /.col -->
          <div class="col-4">
                     <?= Html::submitButton('Login', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            
          </div>
          <!-- /.col -->
        </div>
      <?php ActiveForm::end(); ?>

  
      <!-- /.social-auth-links -->

    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

   
</div>
