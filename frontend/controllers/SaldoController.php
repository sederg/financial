<?php

namespace frontend\controllers;

use frontend\models\Saldo;
use frontend\models\SaldoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use Yii;
use yii\helpers\ArrayHelper;
use yii\data\Pagination;

/**
 * SaldoController implements the CRUD actions for Saldo model.
 */
class SaldoController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Lists all Saldo models.
     *
     * @return string
     */
    public function actionIndex()
    {
         if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/login']);   
     }
        $searchModel = new SaldoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Saldo model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($fecha)
    {
           if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/login']);   
     }
        $searchModel = new SaldoSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);
        $dataProvider->query->where(['MONTH(fecha)'=> substr($fecha,5,2)])->andWhere(['YEAR(fecha)'=> substr($fecha,0, 4)])->andWhere(['status'=>1])->all();
        return $this->render('view', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    public function actionViewcuenta($id)
    {
      
           if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/index']);   
     }
        return $this->render('viewcuenta', [
            'model' => $this->findModel($id),
        ]);
    }
  
    public function actionEstadosituacion($fecha = null,$anno = null,$mes=null)
    {
           if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/login']);   
     }
        if($fecha===null)
        {
            $fecha = date('Y-m-d');
        }
         $saldo = Saldo::find()->join('INNER JOIN','cuenta','saldo.cuentaid=cuenta.id')->where(['MONTH(saldo.fecha)'=> substr($fecha,5,2)])->andWhere(['YEAR(saldo.fecha)'=> substr($fecha,0, 4)])->andWhere(['saldo.status'=>1])->andWhere(['not like','cuenta.grupo_cuentaid',['11','12']])->orderBy('cuenta.grupo_cuentaid')->one();
        if(!$saldo)
        {
         $fechaanterior = SaldoController::fechaperiodoanterior($fecha); 
         if(strlen($fechaanterior['mes'])<2)
         {
           $mes = '0'.$fechaanterior['mes'];  
         }
         
         Yii::$app->session->setFlash('no_datos');
         Yii::$app->session->setFlash("periodo", SaldoController::meses($fechaanterior['mes'])."/".$fechaanterior['anno']);
         return   $this->redirect(['saldo/estadosituacion','fecha' =>$fechaanterior['anno'].'-'.$mes.'-15' ]);   
        }
//        $searchModel = new SaldoSearch();
//        $dataProvider = $searchModel->search($this->request->queryParams);
//        $dataProvider->query->join('INNER JOIN','cuenta','saldo.cuentaid=cuenta.id')->where(['MONTH(saldo.fecha)'=> substr($fecha,5,2)])->andWhere(['YEAR(saldo.fecha)'=> substr($fecha,0, 4)])->andWhere(['saldo.status'=>1])->andWhere(['not like','cuenta.grupo_cuentaid',['11','12']])->orderBy('cuenta.grupo_cuentaid')->all();
//        $models = $dataProvider->models;
        $models = Saldo::find()->join('INNER JOIN','cuenta','saldo.cuentaid=cuenta.id')->where(['MONTH(saldo.fecha)'=> substr($fecha,5,2)])->andWhere(['YEAR(saldo.fecha)'=> substr($fecha,0, 4)])->andWhere(['saldo.status'=>1])->andWhere(['not like','cuenta.grupo_cuentaid',['11','12']])->orderBy('cuenta.grupo_cuentaid')->all();
       if($anno!=null&&$mes!=null)
       {
        foreach ($models as $saldo) 
        {
           
           // $saldo->fecha = $anno;
            $saldo->status = $anno.$mes;
        }
       // return print_r($models);
       // $dataProvider->setPagination(new Pagination(['totalCount' => $dataProvider->getTotalCount()]));
//        $dataProvider->setModels($models);
       }
      $dataProvider = new ArrayDataProvider([
                'allModels' => $models,
                'pagination' => [
                    'pageSize' => 1000,
                ],
                
            ]);
        return $this->render('estadosituacion', [
           // 'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'anno'=>$anno,
            'mes'=>$mes,
            'mesact'=> SaldoController::meses(substr($fecha, 5,2)),
            'annoact'=>substr($fecha, 0,4),
            'fecha'=>$fecha,
        ]);
    }
        public function actionSelecionarmes($fecha,$act)
    {
        if(Yii::$app->request->post())
        {
     // return print_r($_POST);
            
        $mes = $_POST['Mes'];
        $anno = $_POST['Año'];
      
      // $fechaB =  Yii::$app->formatter->asDate($anno.'-0'.$mes.'-15','Y-mm-d');
            if($act ==1 )
            {
            return $this->redirect(['saldo/estadosituacion','fecha'=>$fecha,'mes'=>$mes,'anno'=>$anno]);  
            }
            if($act ==2 )
            {
            return $this->redirect(['saldo/estructura','fecha'=>$fecha,'annoB'=>$anno,'mesB'=>$mes]);  
            }
            if($act ==3 )
            {
            return $this->redirect(['grupo-cuenta/flujocaja','fecha'=>$fecha,'annoB'=>$anno,'mesB'=>$mes]);  
            }
            if($act ==4 )
            {
            return $this->redirect(['saldo/cuadrante','fecha'=>$fecha,'annoB'=>$anno,'mesB'=>$mes]);  
            }
            if($act ==5 )
            {
            return $this->redirect(['saldo/estadoresultado','fecha'=>$fecha,'annoB'=>$anno,'mesB'=>$mes]);  
            }
        }
        else{
            return $this->render('selecionarmes',['fecha'=>$fecha]
                                );
            }
        
}
    
    public static function periodoanterior($id)
    {
       $saldo = Saldo::find()->where(['id'=>$id])->one();
      if($saldo)
      {
        $fecha = $saldo->fecha;
        $mes = substr($fecha,5,2);
        $anno = substr($fecha,0,4);
        if($mes == 1)
        {
            $mesant = 12;
            $anno = $anno-1;
        }else{
            $mesant = $mes-1;
        }
        $saldoant = Saldo::find()->where(['cuentaid'=>$saldo->cuentaid,'empresaid'=>$saldo->empresaid,'status'=>1])->andWhere(['MONTH(fecha)'=>$mesant,'YEAR(fecha)'=>$anno])->one();
        if($saldoant)
        {
            return $saldoant;
        }else{
            return false;
        }
      }
    }
    public static function compararperido($id,$annoB)
    {
       $saldo = Saldo::find()->where(['id'=>$id])->one();
      if($saldo)
      {
         if(strlen($annoB) == 1)
         {
             
         $fecha = $saldo->fecha;
        $mes = substr($fecha, 5, 2);
        $anno = substr($fecha, 0,4);
            if($mes == 1)
            {
                $mesant = 12;
                $anno = $anno-1;
            }else{
                $mesant = $mes-1;
            }
         }else{
             if(strlen($annoB==5))
             {
                $mesant = substr($annoB, 4,1);
                $anno = substr($annoB, 0,4);
                 
             }else{
                $mesant = substr($annoB, 4,2);
                $anno = substr($annoB, 0,4);
                  
             }
            
         }
        $saldoant = Saldo::find()->where(['cuentaid'=>$saldo->cuentaid,'empresaid'=>$saldo->empresaid,'status'=>1])->andWhere(['MONTH(fecha)'=>$mesant,'YEAR(fecha)'=>$anno])->one();
        if($saldoant)
        {
            return $saldoant;
        }else{
            return false;
        }
      }
      //  return $anno;
    }

    /**
     * Creates a new Saldo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
           if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/login']);   
     }
        $model = new Saldo();
        
        $modelsaldos = \frontend\models\Cuenta::find()->where(['status'=>1])->all();
        if($modelsaldos)
        {
            foreach ($modelsaldos as $model) 
            {
             $model->status = 0;   
            }  
        }
         $dataprovidersaldos = new ArrayDataProvider([
                'allModels' => $modelsaldos,
                'pagination' => [
                    'pageSize' => 1000,
                ],
                'sort' => [
                    'attributes' => ['id', 'name'],
                ],
            ]);
        if ($this->request->isPost) 
        {
            if ($model->load($this->request->post()) ) 
            {
               $fecha = $_POST['Cuenta']['fecha'];
                foreach ($_POST['Cuenta'] as $key => $sal)
               {
                   if($key !='fecha')
                   {
                   $saldo = new Saldo();
               $saldo->cuentaid = $sal['id'];
                   $saldo->saldo = $sal['status'];
                   $saldo->fecha = $fecha;
                   $saldo->empresaid = \frontend\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->entidad->id;
                   $saldo->save('false');
                   }
                    
                }
                
                //return print_r($_POST);
                return $this->redirect(['view', 'fecha' => $fecha]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
            'dataprovidersaldos'=>$dataprovidersaldos,
        ]);
    }
    public function actionEstructura($fecha = null,$annoB = null,$mesB = null) 
    {
         if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/login']);   
     }
        if($fecha == null)
        {
          $fecha = date('Y-m-d');  
        }
   // return print_r($annoB.'-'.$mesB);
        
        $mes = substr($fecha, 5, 2);
        $anno = substr($fecha, 0,4);
        if($annoB == null && $mesB ==null)
        {
            if($mes == 1)
            {
                $mesant = 12;
                $annoant = $anno-1;
            }else{
                $mesant = $mes-1;
                $annoant = $anno;
            }
            
        }else{
                $annoant = $annoB;
                $mesant = $mesB;
            
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
    $saldoant = Saldo::find()->join('INNER JOIN', 'cuenta', 'saldo.cuentaid = cuenta.id')->where(['saldo.empresaid'=>$empresaid,'saldo.status'=>1])->andWhere(['YEAR(fecha)'=> $annoant,'MONTH(fecha)'=>$mesant])/*->andWhere(['cuenta.grupo_cuentaid'=>$grupo_cuentaid])*/->all(); 
    // return print_r($saldo); 
    $periodo = $this->meses($mes).'/'.substr($fecha, 0,4);
         $periodoant =$this->meses($mesant).'/'.$annoant; 
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
         if($saldoant)
         {    
          $counta = 0;
         foreach ($saldoant as $key => $sald) 
         {
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
             if($counta==0)
             {
                 
             $saldoActFant = $sald->saldo;  
             $counta++;
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
        }
        // return print_r($saldoant);
         $saldoPatrimonioA[] = $this->llenadoVar('Patrimonio', substr($fecha, 0,7), $saldoPatrimonio);
         $saldoPatrimonioA[] = $this->llenadoVar('Patrimonio', $annoant.'-'.$mesant, $saldoPatrimonioant);
         $saldoPasivoA[] = $this->llenadoVar('Capital', substr($fecha, 0,7), $saldoPasivo);
         $saldoPasivoA[] = $this->llenadoVar('Capital', $annoant.'-'.$mesant, $saldoPasivoant);
       //  $activos = \frontend\models\GrupoCuenta::findAll(['status'=>1,'grupo_generalid'=>1]);
         $saldoActivoC[] = $this->llenadoVar('Activos Circulantes', substr($fecha, 0,7), $saldoActC);
         $saldoActivoLP[] = $this->llenadoVar('Activos a Largo Plazo', substr($fecha, 0,7), $saldoActLP);
         $saldoActivoF[] = $this->llenadoVar('Activos Fijos', substr($fecha, 0,7), $saldoActF);
         $saldoActivoD[] = $this->llenadoVar('Activos Diferidos', substr($fecha, 0,7), $saldoActD);
         $saldoActivoO[] = $this->llenadoVar('Otros Activos', substr($fecha, 0,7), $saldoActO);
         $saldoActivoC[] = $this->llenadoVar('Activos Circulantes',  $annoant.'-'.$mesant, $saldoActCant);
         $saldoActivoLP[] = $this->llenadoVar('Activos a Largo Plazo',  $annoant.'-'.$mesant, $saldoActLPant);
         $saldoActivoF[] = $this->llenadoVar('Activos Fijos',  $annoant.'-'.$mesant, $saldoActFant);
         $saldoActivoD[] = $this->llenadoVar('Activos Diferidos', $annoant.'-'.$mesant, $saldoActDant);
         $saldoActivoO[] = $this->llenadoVar('Otros Activos',  $annoant.'-'.$mesant, $saldoActOant);
        // $saldoPasivo[] = $this->llenadoVar('Capital', $anno.'-'.$mesant, $saldoPasivoantant);
        
          return $this->render('estructura', [
            'saldoPatrimonioA' => $saldoPatrimonioA,
            'saldoPasivoA' => $saldoPasivoA,
            'saldoActivoC' => $saldoActivoC,
            'saldoActivoLP' => $saldoActivoLP,
            'saldoActivoD' => $saldoActivoD,
            'saldoActivoO' => $saldoActivoO,
            'saldoActivoF' => $saldoActivoF,
            'periodo' => $periodo,
            'periodoant' => $periodoant,
             'fecha'=>$fecha, 
        ]);
         
         return print_r($saldoPasivo." ".$saldoPatrimonio);
         
     }else{
                // return print_r($mesant);
                 if(strlen($mesant)<2)
                 {
                  $mesant = '0'.$mesant;  
                 }
                 Yii::$app->session->setFlash('no_datos');
                 Yii::$app->session->setFlash("periodo",$periodoant);
                 return $this->redirect(['saldo/estructura','fecha'=>$anno.'-'.$mesant.'-25','annoB'=>$annoB,'mesB'=>$mesB]);
           
       }
      
     }
     
  
     public function actionEstadoresultado($fecha=null, $annoB = null,$mesB=null) 
     {
       if($fecha == null)
        {
          $fecha = date('Y-m-d');  
        }
        if($annoB==null && $mesB==null)
        {
            
        $fechaant = $this->fechaperiodoanterior($fecha);
        $periodoant = $this->meses($fechaant['mes']).'/'.$fechaant['anno'] ;
        }else{
        $periodoant = $this->meses($mesB).'/'.$annoB ;
        $fechaant['anno']=$annoB ;
        $fechaant['mes']=$mesB ;
          
        }
        
        $mes = substr($fecha, 5, 2);
        $anno = substr($fecha, 0,4); 
        $periodo = $this->meses($mes).'/'.$anno ;
     // $ingresos = \frontend\models\Cuenta::find()->join('INNER JOIN','grupo_cuenta', 'cuenta.grupo_cuentaid=grupo_cuenta.id')->where(['grupo_cuenta.grupo_generalid'=>4])->all();
    //  $gastos = \frontend\models\Cuenta::find()->join('INNER JOIN','grupo_cuenta', 'cuenta.grupo_cuentaid=grupo_cuenta.id')->where(['grupo_cuenta.grupo_generalid'=>5])->all();
        $empresa = \frontend\models\User::findOne(Yii::$app->user->getId())->entidad->id;
        $buscar = array(37,32,33,40,41,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60);
       
        $datos = SaldoController::buscarorganizardatos($buscar, $anno, $mes, $empresa);
        $datosant = SaldoController::buscarorganizardatos($buscar, $fechaant['anno'], $fechaant['mes'], $empresa);
       // $saldos = ArrayHelper::getColumn($datosant, 'saldo'); 
       // $datosM = \yii\helpers\ArrayHelper::merge($datos, $saldos);
       // return print_r($datosM);
        
         return $this->render('estadoresultado',[
            'periodo'=>$periodo, 
            'periodoant'=>$periodoant, 
            'datos'=>$datos, 
            'fecha'=>$fecha,
            'fechaant'=>$fechaant,
            'datosant'=>$datosant, 
            'anno' =>$anno,
            'mes'=>$mes,
            'idempresa'=>\frontend\models\User::findOne(Yii::$app->user->getId())->entidad->id,
         ]);
         
     }
    public function actionCuadrante($fecha = null, $annoB = null, $mesB = null) 
    {
         if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/login']);   
     }
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
        $liquidezB = null;
        $cuadranteB = null;
        $saldoretabilidadB = null;
        if($annoB!=null && $mesB!=null)
        {
            
         $liquidezB = GrupoCuentaController::liquidez($mesB, $annoB);
         $rentabilidadB = GrupoCuentaController::rentabilidad($mesB,  $annoB ,$empresaid);
         if($liquidezB&&$rentabilidadB)
         {
         $liquidezB = Yii::$app->formatter->format($liquidezB, ['decimal',2]);
         $saldoretabilidadB = Yii::$app->formatter->format($rentabilidadB, ['decimal',2]);
         $cuadranteB = SaldoController::buscarcuadrante($liquidezB, $saldoretabilidadB);
        }
        }
         $liquidez = GrupoCuentaController::liquidez($mes, $anno = substr($fecha, 0,4));
         $rentabilidad = GrupoCuentaController::rentabilidad($mes,  $anno = substr($fecha, 0,4),$empresaid);
         if($liquidez&&$rentabilidad)
         {
         $liquidez = Yii::$app->formatter->format($liquidez, ['decimal',2]);
         $saldoretabilidad = Yii::$app->formatter->format($rentabilidad, ['decimal',2]);
        $empresa =\frontend\models\User::findOne(Yii::$app->user->getId())->entidad->nombre;
         $cuadrante = SaldoController::buscarcuadrante($liquidez, $saldoretabilidad);
          return $this->render('cuadrante', [
             'periodo' => SaldoController::meses($mes).'/'.$anno,
             'periodoB' => SaldoController::meses($mesB).'/'.$annoB,
             'empresa' => $empresa,
            'liquidez' => $liquidez,
            'cuadrante' => $cuadrante,
            'saldoretabilidad' => $saldoretabilidad,
            'liquidezB' => $liquidezB,
            'cuadranteB' => $cuadranteB,
            'saldoretabilidadB' => $saldoretabilidadB,
              'annoB'=>$annoB,
              'mesB'=>$mesB,
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
                 return $this->redirect(['saldo/cuadrante','fecha'=>$anno.'-'.$mesant.'-25']);
           
         }
    
      
     }
     static public function llenadoVar($componente,$periodo,$saldo) 
     {
        $saldoP['componente'] = $componente;
         $saldoP['si'] = $saldo;
         $saldoP['periodo'] = $periodo;  
         return $saldoP;
     }    
    public static function percent($model) 
    {
       $saldo = Saldo::find()->join('INNER JOIN', 'cuenta', 'saldo.cuentaid = cuenta.id')->where(['saldo.empresaid'=>$model->empresaid,'saldo.status'=>1])->andWhere(['YEAR(fecha)'=> substr($model->fecha,0, 4),'MONTH(fecha)'=>substr($model->fecha,5, 2)])->andWhere(['cuenta.grupo_cuentaid'=>$model->cuenta->grupo_cuentaid])->all(); 
    
       if($saldo)
       {
           $importe = 0;
           foreach ($saldo as $key => $sal) 
           {
            $importe += $sal->saldo;   
           }
           return $importe;
       }else{return 0;}
    }
 
    /**
     * Updates an existing Saldo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['viewcuenta', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Saldo model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Saldo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Saldo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Saldo::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    static public function meses($mes) 
    {
        switch ($mes)
        {
         case '01':
         {
          return "enero";
          
         }   
         case '02':
         {
          return "febrero";
          
         }   
         case '03':
         {
          return "marzo";
          
         }   
         case '04':
         {
          return "abril";
          
         }   
         case '05':
         {
          return "mayo";
          
         }   
         case '06':
         {
          return "junio";
          
         }   
         case '07':
         {
          return "julio";
          
         }   
         case '08':
         {
          return "agosto";
          
         }   
         case '09':
         {
          return "septiembre";
          
         }   
         case '10':
         {
          return "octubre";
          
         }   
         case '11':
         {
          return "noviembre";
          
         }   
         case '12':
         {
          return "diciembre";
          
         }   
        }
        
    }
    static public function fechaperiodoanterior($fecha) 
    {
       
        $mes = substr($fecha, 5, 2);
        $anno = substr($fecha, 0,4);
        if($mes == 1)
        {
            $mesant = 12;
            $anno = $anno-1;
        }else{
            $mesant = $mes-1;
        }  
        $fechas['mes']=$mesant;
        $fechas['anno']=$anno;
        return $fechas;
    }
    static public function corregirmes($mes) 
    {
     if(strlen($mes)<2)
     {
         $mes = "0".$mes;
     }
     return $mes;
    }
    static public function buscarcuadrante($liquidez,$rentabilidad) 
    {
     if($liquidez <= 0 && $rentabilidad <= 0)
     {
         $cuadrante = 'Cuadrante III Empresa de muerte.';
     }
     if($liquidez > 0 && $rentabilidad > 0)
     {
         $cuadrante = 'Cuadrante I Empresa Consolidada y en desarrollo.';
     }
     if($liquidez > 0 && $rentabilidad < 0)
     {
         $cuadrante = '<p class="text-primary">Cuadrante I Empresa en reflotacion Financiera</p>.';
     }
     if($liquidez < 0 && $rentabilidad > 0)
     {
         $cuadrante = 'Cuadrante II Empresa en Redimencionamiento.';
     }
     return $cuadrante;
    }
    static public function buscarsaldo($id,$anno,$mes,$empresa)
    {
         $saldo = Saldo::find()->where(['cuentaid'=>$id,'YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->one();
         if($saldo)
         {return $saldo;}
         else{return false;}
    }
    static public function organizardatos($orden,$datos,$ordenados)
    {
        foreach ($orden as $id) 
        {
            foreach ($datos as $dato) 
            {
              if($id == $dato->cuentaid)
              {
               $ordenados[$dato->cuenta->nombre] =$dato;    
              }
            }
        }
        return $ordenados;
        
    }
    static public function buscarorganizardatos($orden,$anno,$mes,$empresa)
    {
        $ordenados=[];
        $periodo = SaldoController::meses($mes).'/'.$anno;
        foreach ($orden as $key=>$id) 
        {
            $cuenta = \frontend\models\Cuenta::find()->where(['id'=>$id])->one();
            $saldo = Saldo::find()->where(['cuentaid'=>$id,'YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->one();
            
           // $ordenados[$cuenta->nombre]='hola';
            $ordenados[$cuenta->nombre]['id'] = $cuenta->id;
            if($saldo)
            {
            $ordenados[$cuenta->nombre]['saldo']=$saldo->saldo;
                
            }else{
                $ordenados[$cuenta->nombre]['saldo'] = 0.0;
               
            }
            
        }
        return $ordenados;
        
    }
    static public function agregardatos($datos,$clave) 
    {
        $valor = '';
        foreach ($datos as $key=>$dato)
        {
          if($key == $clave)
          {
           $valor = $dato['saldo'];   
          }
        }
        return $valor;
    
    }


    static public function saldoventanetas($mes,$anno,$idempresa) 
    {
   
     return SaldoController::ventasnetas($anno,$mes,$idempresa);
        
    }
    static  public function ventasnetas($anno,$mes,$empresa) 
    {
       // $saldoingreso = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->where(['or ', 'cuentaid=37', ['or', 'cuentaid=32','cuentaid=33','cuentaid=40']])->all();
        $saldoingreso = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->andwhere(['or', 'cuentaid=37', ['or', 'cuentaid=32','cuentaid=33','cuentaid=40']])->all();
        $saldoing = 0;
        if($saldoingreso)
        {
            foreach ($saldoingreso as $value) 
            {
            $saldoing += $value->saldo;
            }   
        }
       // return print_r($saldoingreso);
        $saldogasto  = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->andwhere(['or', 'cuentaid=41', ['or', 'cuentaid=42','cuentaid=43']])->all();
    if($saldogasto)
    {
            foreach ($saldogasto as $value) 
            {
            $saldoing -= $value->saldo;
            }   
        
    }
        return $saldoing;
    }
    static  public function UPBV($anno,$mes,$empresa) 
    {
       // $saldoingreso = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->where(['or ', 'cuentaid=37', ['or', 'cuentaid=32','cuentaid=33','cuentaid=40']])->all();
        $saldoingreso = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->andwhere(['or', 'cuentaid=44', ['or', 'cuentaid=45']])->all();
        $saldoing = 0;
        if($saldoingreso)
        {
            foreach ($saldoingreso as $value) 
            {
            $saldoing += $value->saldo;
            }   
        }
  
        return  SaldoController::saldoventanetas($mes, $anno, $empresa)-$saldoing;
    }
    static  public function UPNV($anno,$mes,$empresa) 
    {
       // $saldoingreso = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->where(['or ', 'cuentaid=37', ['or', 'cuentaid=32','cuentaid=33','cuentaid=40']])->all();
        $saldoingreso = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->andwhere( 'cuentaid=46')->all();
        $saldoing = 0;
        if($saldoingreso)
        {
            foreach ($saldoingreso as $value) 
            {
            $saldoing += $value->saldo;
            }   
        }
  
        return $saldoing + SaldoController::UPBV($anno,$mes,$empresa);
    }
    static  public function UPO($anno,$mes,$empresa) 
    {
       // $saldoingreso = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->where(['or ', 'cuentaid=37', ['or', 'cuentaid=32','cuentaid=33','cuentaid=40']])->all();
        $saldoingreso = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->andwhere(['or', 'cuentaid=47', ['or', 'cuentaid=48', 'cuentaid=49']])->all();
        $saldoing = 0;
        if($saldoingreso)
        {
            foreach ($saldoingreso as $value) 
            {
            $saldoing += $value->saldo;
            }   
        }
  
        return SaldoController::UPNV($anno,$mes,$empresa)-$saldoing;
    }
    static  public function UtilidadPeriodo($anno,$mes,$empresa) 
    {
       // $saldoingreso = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->where(['or ', 'cuentaid=37', ['or', 'cuentaid=32','cuentaid=33','cuentaid=40']])->all();
        $saldoingreso = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->andwhere(['or', 'cuentaid=56', ['or', 'cuentaid=57', 'cuentaid=58', 'cuentaid=59', 'cuentaid=60']])->all();
        $saldogastos = Saldo::find()->where(['YEAR(fecha)'=>$anno,'MONTH(fecha)'=>$mes,'empresaid'=>$empresa,'status'=>1])->andwhere(['or', 'cuentaid=50', ['or', 'cuentaid=51', 'cuentaid=52', 'cuentaid=53', 'cuentaid=54', 'cuentaid=55']])->all();
        $saldoing = 0;
        $saldogas = 0;
        if($saldoingreso)
        {
            foreach ($saldoingreso as $value) 
            {
            $saldoing += $value->saldo;
            }   
        }
        if($saldogastos)
        {
            foreach ($saldogastos as $value) 
            {
            $saldogas += $value->saldo;
            }   
        }
        $saldoUP = $saldoing-$saldogas;
  
        $utilidad = SaldoController::UPO($anno, $mes, $empresa)-$saldogas;
          if($utilidad < 0)
     {
       return 0; 
     }else{
         
        return $utilidad;
     }
        
    }
    static public function reserva($anno,$mes,$empresa) 
    {
     $reserva = (SaldoController::UtilidadPeriodo($anno,$mes,$empresa)*5)/100;
     if($reserva < 0)
     {
       return 0; 
     }else{
         
        return $reserva;
     }
        }
    static public function UsI($anno,$mes,$empresa) 
    {
     $utilidad = SaldoController::UtilidadPeriodo($anno,$mes,$empresa);
     $reserva = SaldoController::reserva($anno,$mes,$empresa);
     $UsI = ($utilidad-$reserva);
     $Usi = ($UsI*35)/100;
     if($Usi < 0)
     {
       return 0; 
     }else{
         
        return $Usi;
     }
        }
    static public function UdI($anno,$mes,$empresa) 
    {
     $utilidad = SaldoController::UtilidadPeriodo($anno,$mes,$empresa);
     $reserva = SaldoController::reserva($anno,$mes,$empresa);
     $UsI = SaldoController::UsI($anno,$mes,$empresa);
     $UdI = $utilidad-$reserva-$UsI;
    
     if($UdI < 0)
     {
       return 0; 
     }else{
         
        return $UdI;
     }
        }
}
