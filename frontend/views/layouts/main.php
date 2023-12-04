<?php

/* @var $this \yii\web\View */
/* @var $content string */

use common\widgets\Alert;
use frontend\assets\AppAsset;
use yii\bootstrap4\Breadcrumbs;
use yii\bootstrap4\Html;
use yii\bootstrap4\Nav;
use yii\bootstrap4\NavBar;
use yii\widgets\Menu;


AppAsset::register($this);
$asset = frontend\assets\AppAsset::register($this);
$baseUrl = $asset->baseUrl;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <link rel="shortcut icon" href="<?=Yii::$app->urlManager->baseUrl.'/images/analisis_ico1.png'?>">
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => '<img src="'.$baseUrl.'/images/analisis_economico.png" style="display:inline; horizontal-align: top; height:70px;">',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-expand-md navbar-dark  fixed-top nav-sisga',
        ],
    ]);
    $menuItems = [
        ['label' => 'Panel', 'url' => ['/site/index']],
       // ['label' => 'About', 'url' => ['/site/about']],
        //['label' => 'Contact', 'url' => ['/site/contact']],
    ];
    if (Yii::$app->user->isGuest) {
      //  $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = ['label' => 'Nomencladores',
                                    'items' =>[
                                                  
                                                    ['label' => 'Grupos de Cuentas', 'url' => ['/grupo-cuenta/index']],
                                                    ['label' => 'Cuentas', 'url' => ['/cuenta/index']],
                                                
                                              ]
                               ];
          $menuItems[] = ['label' => 'Datos Economicos', 'url' => ['/saldo/index']];
        $menuItems[] = ['label' => 'Reportes',
                                    'items' =>[
                                                  
                                                    ['label' => 'Estado de Situacion', 'url' => ['/saldo/estadosituacion',null,null]],
                                                    ['label' => 'Estado de Resultado', 'url' => ['/saldo/estadoresultado']],
                                                    ['label' => 'Estructura', 'url' => ['/saldo/estructura',null,null,null]],
                                                    ['label' => 'Razones financieras', 'url' => ['/grupo-cuenta/razones']],
                                                    ['label' => 'Flujo de Caja', 'url' => ['/grupo-cuenta/flujocaja']],
                                                    ['label' => 'cuadrante', 'url' => ['/saldo/cuadrante']],
                                                
                                              ]
                               ];
           
        
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post', ['class' => 'form-inline'])
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->username . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav ml-auto'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>
<section id="title" class="emerald">
    <div class="container">
      <div class="row">
        <div class="col-sm-6">
          <h1> <?php echo ($this->params['tittle']) ? (yii\helpers\ArrayHelper::getValue($this->params['tittle'],0)):[];?></h1>
        <!-- <h5><?php //echo ($this->params['desc']) ? (yii\helpers\ArrayHelper::getValue($this->params['desc'],0)):[];?></h5>-->
        </div>
        <div class="col-sm-6 ">
            <div class="pull-right">   
           <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
                </div>
        </div>
      </div>
    </div>
  </section>
    
    
    
    
    <div class="container">
       
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>



    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
              <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y').' v 1.0.0' ?> </p> 
                </div>
                <div class="col-sm-4 ">
                    <p class="center"><?= Yii::powered().' por la Empresa De Ingenieria del Reciclaje (ISDE)' ?> &copy;
                    </p>   
                </div>
                <div class="col-sm-4">
                 <p class="pull-right">
                     <?php if(!Yii::$app->user->isGuest)
                         {?>
                 <span class = "glyphicon glyphicon-user" style="right: 365px"> 
                 
                     <p>  
                     <?php
                     //echo strtolower(Yii::$app->user->identity->username).' : ' .strtoupper( frontend\controllers\UserController::findModel(Yii::$app->user->getId())->rol->rol)/*.' - '.\frontend\controllers\EntidadController::findModel( \frontend\controllers\UserController::findModel(Yii::$app->user->getId())->entidadid) ? \frontend\controllers\UserController::findModel(Yii::$app->user->getId())->entidad->nombre : 'Contint'*/;
                      
                     }?>
                    </p>
                     
                 </span>      
                 </p>
                
                </div>

            </div>
        </div>
    </footer><!--/#footer-->


<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
