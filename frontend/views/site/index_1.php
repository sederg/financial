<?php
use yii\helpers\Html;
use yii\bootstrap4\Alert;
$this->title = 'Sistema de analisis económico';

$this->params['tittle'][] = $this->title;
$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;
?>

<div class="site-index">

  

    <div class="body-content">
 <?php if(Yii::$app->session->hasFlash("ok_contraseña")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-success'], 'body' => "La contraseña del usuario ". $_SESSION['user']. " ha sido cambiada con exito. "]);
        ?>
    <?php endif; ?>        
 <?php if(Yii::$app->session->hasFlash("error")):?>
        <?php 
           //Mensaje para mostrar cuando se ha insertado correctamente. Nota: Se puede utilizar otras clasificaciones como:
           //alert-success ; alert-warning ;  alert-danger
           echo Alert::widget(['options' => ['class' => 'alert-danger'], 'body' => "No existen datos para mostrar "]);
        ?>
    <?php endif; ?>        
      

        <div  align ="center" style="margin-top: 200px;">
                  
                 <img src=<?php echo$baseUrl."/images/analisis_economico.png"?> style="display:inline; horizontal-align: top; height:200px;" />
             </div>
             <div  align ="center">
                 <img src=<?php echo$baseUrl."/images/isde.png"?> style="display:inline; horizontal-align: top; height:50px;" />
                  
             </div>
    <?php
    if(Yii::$app->user->isGuest)
    {?>
        
      <div class="login-box">

            <div class="card-body login-card-body">
                  <div class="social-auth-links text-center mb-3">
                       <?=Html::a('Entrar ', ['/site/login'], ['class'=>'btn btn-block btn-primary'])
                       ?>     
                </div>
             </div>
        </div>
               
       
        <?php
    
    }
    ?>
        
          
          
     <?php // } ?>

    </div>
</div>