<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Saldo;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
   public function actionIndex($fecha = null)
    {
       if(Yii::$app->user->isGuest)
       {
         $this->layout = 'main_login';
          return $this->render('index');
       }else{
        $this->layout = 'main_index';  
             if($fecha == null)
        {
          $fecha = date('Y-m-d');  
        }
        
       $mes = substr($fecha, 5, 2);
        $anno = substr($fecha, 0,4);
        if($mes == 1)
        {
            $mesant = 12;
            $anno = $anno-1;
        }else{
            $mesant = $mes-1;
        }
     $empresaid =\frontend\models\User::findOne(Yii::$app->user->getId())->entidad->id;
    $saldoPatrimonio = 0;
    $saldoPasivo = 0;
    $saldoActC = 0;
    $saldoActF = 0;
    $saldoActD = 0;
    $saldoActLP = 0;
    $saldoActO= 0;
    $saldoActCant = 0;
    $saldoActFant = 0;
    $saldoActDant = 0;
    $saldoActLPant = 0;
    $saldoActOant= 0;
    $saldoPatrimonioant = 0;
    $saldoPasivoant = 0;
    $saldo = Saldo::find()->join('INNER JOIN', 'cuenta', 'saldo.cuentaid = cuenta.id')->where(['saldo.empresaid'=>$empresaid,'saldo.status'=>1])->andWhere(['YEAR(fecha)'=> substr($fecha,0, 4),'MONTH(fecha)'=>substr($fecha,5, 2)])/*->andWhere(['cuenta.grupo_cuentaid'=>$grupo_cuentaid])*/->all(); 
    $saldoant = Saldo::find()->join('INNER JOIN', 'cuenta', 'saldo.cuentaid = cuenta.id')->where(['saldo.empresaid'=>$empresaid,'saldo.status'=>1])->andWhere(['YEAR(fecha)'=> $anno,'MONTH(fecha)'=>$mesant])/*->andWhere(['cuenta.grupo_cuentaid'=>$grupo_cuentaid])*/->all(); 
    // return print_r($saldo); 
    if ($saldo)
     {
        $count = 0; 
        foreach ($saldo as $key => $sal) 
         {
          
             if($sal->cuenta->grupo_cuentaid == 1)
           {
             $saldoActC += $sal->saldo;  
             
           }
             if($sal->cuenta->grupo_cuentaid == 2)
           {
             $saldoActLP += $sal->saldo;  
             
           }
             if($sal->cuenta->grupo_cuentaid == 3)
           {
             if($count==0)
             {
                 
             $saldoActF = $sal->saldo;  
             $count++;
             }else{
               $saldoActF = $saldoActF-$sal->saldo;  
             }
             
           }
             if($sal->cuenta->grupo_cuentaid == 4)
           {
             $saldoActD += $sal->saldo;  
             
           }
             if($sal->cuenta->grupo_cuentaid == 5)
           {
             $saldoActO += $sal->saldo;  
             
           }
             if($sal->cuenta->grupoCuenta->grupo_generalid == 3)
           {
             $saldoPasivo += $sal->saldo;  
             
           }
           if($sal->cuenta->grupoCuenta->grupo_generalid == 2)
           {
             $saldoPatrimonio += $sal->saldo;  
             
           }
         }
         foreach ($saldoant as $key => $sald) 
         {
          $count = 0;
             if($sald->cuenta->grupo_cuentaid == 1)
           {
             $saldoActCant += $sald->saldo;  
             
           }
             if($sald->cuenta->grupo_cuentaid == 2)
           {
             $saldoActLPant += $sald->saldo;  
             
           }
             if($sald->cuenta->grupo_cuentaid == 3)
           {
              if($count==0)
             {
                 
             $saldoActFant = $sal->saldo;  
             $count++;
             }else{
               $saldoActFant = $saldoActFant-$sald->saldo;  
             }
             
           }
             if($sald->cuenta->grupo_cuentaid == 4)
           {
             $saldoActDant += $sald->saldo;  
             
           }
             if($sald->cuenta->grupo_cuentaid == 5)
           {
             $saldoActOant += $sald->saldo;  
             
           }
             if($sald->cuenta->grupoCuenta->grupo_generalid == 3)
           {
             $saldoPasivoant += $sald->saldo;  
             
           }
           if($sald->cuenta->grupoCuenta->grupo_generalid == 2)
           {
             $saldoPatrimonioant += $sald->saldo;  
             
           }
         }
        
         $periodo = SaldoController::meses($mes).'/'.substr($fecha, 0,4);
       
         $saldoPatrimonioA[] = SaldoController::llenadoVar('Patrimonio', substr($fecha, 0,7), $saldoPatrimonio);
       
         $saldoPasivoA[] = SaldoController::llenadoVar('Capital', substr($fecha, 0,7), $saldoPasivo);
       
       //  $activos = \frontend\models\GrupoCuenta::findAll(['status'=>1,'grupo_generalid'=>1]);
         $saldoActivoC[] = SaldoController::llenadoVar('Activos Circulantes', substr($fecha, 0,7), $saldoActC);
         $saldoActivoLP[] = SaldoController::llenadoVar('Activos a Largo Plazo', substr($fecha, 0,7), $saldoActLP);
         $saldoActivoF[] = SaldoController::llenadoVar('Activos Fijos', substr($fecha, 0,7), $saldoActF);
         $saldoActivoD[] = SaldoController::llenadoVar('Activos Diferidos', substr($fecha, 0,7), $saldoActD);
         $saldoActivoO[] = SaldoController::llenadoVar('Otros Activos', substr($fecha, 0,7), $saldoActO);
        
      //-------------------
         
          $mes = substr($fecha,5,2);
        $anno = substr($fecha,0,4);
      
         
        $cicloinventario = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format(GrupoCuentaController::cicloinventario($mes, $anno), ['decimal', 1]));
        $ciclopago = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format(GrupoCuentaController::ciclopagos($mes, $anno), ['decimal', 1]));
        $ciclocobro = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format(GrupoCuentaController::ciclocobro($mes, $anno), ['decimal', 1]));
        $convercionefectivo = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format(GrupoCuentaController::cicloconversionefectivo($mes, $anno), ['decimal', 1]));
        $capital = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format(GrupoCuentaController::capitaltrabajo(GrupoCuentaController::ciclopagos($mes, $anno),GrupoCuentaController::cicloconversionefectivo($mes, $anno)), ['decimal', 1]));
       
        
      
         $periodo = SaldoController::meses($mes).'/'.substr($fecha, 0,4);
     
         $cinventario[]=$cicloinventario;
         $cpago[]=$ciclopago;
         $ccobro[]=$ciclocobro;
         $efectivo[]=$convercionefectivo;
         $ccapital[]=$capital;
         $empresaid =\frontend\models\User::findOne(Yii::$app->user->getId())->entidad->id;
         $liquidez = Yii::$app->formatter->format(GrupoCuentaController::liquidez($mes, $anno = substr($fecha, 0,4)), ['decimal',2]);
         $saldoretabilidad = Yii::$app->formatter->format(GrupoCuentaController::rentabilidad($mes,  $anno = substr($fecha, 0,4),$empresaid), ['decimal',2]);
         $empresa =\frontend\models\User::findOne(Yii::$app->user->getId())->entidad->nombre;
         $cuadrante = SaldoController::buscarcuadrante($liquidez, $saldoretabilidad);
       //  RETURN print_r($liquidez);
         $saldodisp = 0;
         $saldoinv = 0;
         $liquidezim = 0;
         $disp = 0;
         
     
        $AC = GrupoCuentaController::total(1,$mes,$anno)/1000;
        $PC = GrupoCuentaController::total(6, $mes, $anno)/1000;
        $inventario = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andwhere(['or', 'cuentaid=9', ['or', 'cuentaid=34']])->all();
        $dispon = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andwhere(['or', 'cuentaid=1', ['or', 'cuentaid=2']])->all();
        if($inventario)
        {
          
            foreach ($inventario as $inv) 
            {
             $saldoinv += $inv->saldo;    
            }
            if($saldoinv!=0)
            {
              $saldoinv = $saldoinv/1000;  
            }
        }
        if($dispon)
        {
           
            foreach ($dispon as $d) 
            {
             $saldodisp += $d->saldo;    
            }
            if($saldodisp!=0)
            {
              $saldodisp = $saldodisp/1000;  
            }
        }
        
         if($PC == 0)
        {$liquidez = 0;}
        else{
            
        $liquidez = GrupoCuentaController::liquidez($mes, $anno);
        $liquidezim = ($AC-$saldoinv)/$PC;
        $disp = $saldodisp/$PC;
        }
  
       $solvencia = GrupoCuentaController::solvencia($mes, $anno)/100;
       $endeudamiento = GrupoCuentaController::endeudamiento($mes, $anno);
        
        
        
         //--------------------
        
          return $this->render('index', [
            'saldoPatrimonioA' => $saldoPatrimonioA,
            'saldoPasivoA' => $saldoPasivoA,
            'saldoActivoC' => $saldoActivoC,
            'saldoActivoLP' => $saldoActivoLP,
            'saldoActivoD' => $saldoActivoD,
            'saldoActivoO' => $saldoActivoO,
            'saldoActivoF' => $saldoActivoF,
            'liquidezim'=>Yii::$app->formatter->format($liquidezim, ['currency'/*, $*/]),
           'solvencia'=>Yii::$app->formatter->format($solvencia, ['currency'/*, $*/]),  
           'rentabilidad'=>Yii::$app->formatter->format($saldoretabilidad, ['percent']),  
           'endeudamiento'=>Yii::$app->formatter->format($endeudamiento, ['percent']),  
            
             'cinventario'=>$cinventario,
             'cpago'=>$cpago,
             'ccobro'=>$ccobro,
             'efectivo'=>$efectivo,
             'ccapital'=>$ccapital,
           
             'empresa' => $empresa,
            'liquidez' => $liquidez,
            'cuadrante' => $cuadrante,
            'saldoretabilidad' => $saldoretabilidad,
            'periodo' => $periodo,
               'fecha'=>$fecha,
      
        ]);
       }else{
                // return print_r($mesant);
                 if(strlen($mesant)<2)
                 {
                  $mesant = '0'.$mesant;  
                 }
                 Yii::$app->session->setFlash('no_datos');
                 Yii::$app->session->setFlash("periodo", SaldoController::meses($mesant)."/".$anno);
                 return $this->redirect(['site/index','fecha'=>$anno.'-'.$mesant.'-25']);
           
       }
       
    }
    }
    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
    
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

         $this->layout = 'main_login';
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
   
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if (($user = $model->verifyEmail()) && Yii::$app->user->login($user)) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }
}
