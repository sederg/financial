<?php

namespace frontend\controllers;

use frontend\models\GrupoCuenta;
use frontend\models\GrupoCuentaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;
use frontend\controllers\SaldoController;
use frontend\models\Saldo;
/**
 * GrupoCuentaController implements the CRUD actions for GrupoCuenta model.
 */
class GrupoCuentaController extends Controller
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
     * Lists all GrupoCuenta models.
     *
     * @return string
     */
    public function actionIndex()
    {
          if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/index']);   
     }
        $searchModel = new GrupoCuentaSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GrupoCuenta model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
           if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/index']);   
     }
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new GrupoCuenta model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
         if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/index']);   
     }
        $model = new GrupoCuenta();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionRazones($fecha = null) 
    {
        if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/index']);   
     }
        if($fecha ==null)
        {
        $fecha = date('Y-m-d');    
        }
        $mes = substr($fecha,5,2);
        $anno = substr($fecha,0,4);
        $fechaant = SaldoController::fechaperiodoanterior($fecha);
         $liquidezim = 0;
         $disp = 0;
         
     
        $AC = $this->total(1,$mes,$anno)/1000;
        $PC = $this->total(6, $mes, $anno)/1000;
        $saldo = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->one();
        if($saldo)
        {
        $inventario = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andwhere(['or', 'cuentaid=9', ['or', 'cuentaid=34']])->all();
        $dispon = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andwhere(['or', 'cuentaid=1', ['or', 'cuentaid=2']])->all();
        if($inventario)
        {
          $saldoinv = 0;
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
           $saldodisp = 0;
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
        {$liquidez = 0;
        
        }
        else{
            
            $liquidez = $this->liquidez($mes, $anno);
            $liquidezim = ($AC-$saldoinv)/$PC;
            $disp = $saldodisp/$PC;
        }
        $ciclocobros = $this->ciclocobro($mes, $anno);
        $ciclopagos = $this->ciclopagos($mes, $anno);
        $cicloinventarios = $this->cicloinventario($mes, $anno);
        $endeudamiento = $this->endeudamiento($mes, $anno);
        $autonomia = $this->autonomia($mes, $anno)/100;
       $calidaddeuda = $this->calidaddeuda($mes, $anno)/100;
       $solvencia = $this->solvencia($mes, $anno)/100;
       $rentabilidad = $this->rentabilidad($mes, $anno, \frontend\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->entidad->id);
        
        
        
        
        return $this->render('razones',[
      'liquidez'=>Yii::$app->formatter->format($liquidez, ['currency']),  
      'liquidezim'=>Yii::$app->formatter->format($liquidezim, ['currency']),  
      'disp'=>Yii::$app->formatter->format($disp, ['currency']),  
      'ciclocobros'=>Yii::$app->formatter->format($ciclocobros, ['decimal', '1']),  
      'ciclopagos'=>Yii::$app->formatter->format($ciclopagos, ['decimal', '1']),  
      'cicloinventarios'=>Yii::$app->formatter->format($cicloinventarios, ['decimal', '1']),  
      'endeudamiento'=>Yii::$app->formatter->format($endeudamiento, ['percent', '1']),  
      'autonomia'=>Yii::$app->formatter->format($autonomia, ['percent', '1']),  
      'calidaddeuda'=>Yii::$app->formatter->format($calidaddeuda, ['percent', '1']),  
      'solvencia'=>Yii::$app->formatter->format($solvencia, ['decimal', '2']),  
      'rentabilidad'=>Yii::$app->formatter->format($rentabilidad, ['percent']),
      'fecha'=>$fecha,
      'periodo'=> SaldoController::meses($mes)."/".$anno,
    ]);    
    }else{
                $mesant = $fechaant['mes'];
                 if(strlen($mesant)<2)
                 {
                  $mesant = '0'.$mesant;  
                 }
                 Yii::$app->session->setFlash('no_datos');
                 Yii::$app->session->setFlash("periodo", SaldoController::meses($mesant)."/".$anno);
                 return $this->redirect(['grupo-cuenta/razones','fecha'=>$anno.'-'.$mesant.'-25']);
           
         }
    
        }

    public function actionFlujocaja($fecha = null,$annoB = null,$mesB = null) 
    {
        if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/index']);   
     }
        if($fecha ==null)
        {
        $fecha = date('Y-m-d');    
        }
        $mes = substr($fecha,5,2);
        $anno = substr($fecha,0,4);
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
         return   $this->redirect(['grupo-cuenta/flujocaja','fecha' =>$fechaanterior['anno'].'-'.$mes.'-15' ]);   
        }
         
        $cicloinventario = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format($this->cicloinventario($mes, $anno), ['decimal', 1]));
        $ciclopago = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format($this->ciclopagos($mes, $anno), ['decimal', 1]));
        $ciclocobro = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format($this->ciclocobro($mes, $anno), ['decimal', 1]));
        $convercionefectivo = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format($this->cicloconversionefectivo($mes, $anno), ['decimal', 1]));
        $capital = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format($this->capitaltrabajo($this->ciclopagos($mes, $anno), $this->cicloconversionefectivo($mes, $anno)), ['decimal', 1]));
       
        if($annoB==null&&$mesB==null)
        {
        $fechaant = SaldoController::fechaperiodoanterior($fecha);
            
        }else{
            $fechaant['mes'] = $mesB;
            $fechaant['anno'] = $annoB;
            
        }
        $cicloinventarioant = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format($this->cicloinventario($fechaant['mes'], $fechaant['anno']), ['decimal', 1]));
        $ciclopagoant = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format($this->ciclopagos($fechaant['mes'], $fechaant['anno']), ['decimal', 1]));
        $ciclocobroant = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format($this->ciclocobro($fechaant['mes'], $fechaant['anno']), ['decimal', 1]));
        $convercionefectivoant = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format($this->cicloconversionefectivo($fechaant['mes'], $fechaant['anno']), ['decimal', 1]));
        $capitalant = SaldoController::llenadoVar('Ciclo de Inventario',$anno.'-'.SaldoController::meses($mes),Yii::$app->formatter->format($this->capitaltrabajo($this->ciclopagos($fechaant['mes'], $fechaant['anno']), $this->cicloconversionefectivo($fechaant['mes'], $fechaant['anno'])), ['decimal', 1]));
       
         $periodo = SaldoController::meses($mes).'/'.substr($fecha, 0,4);
         $periodoant = SaldoController::meses($fechaant['mes']).'/'.$fechaant['anno']; 
        
        
        $cinventario[]=$cicloinventario;
        $cinventario[]=$cicloinventarioant;
        $cpago[]=$ciclopago;
        $cpago[]=$ciclopagoant;
        $ccobro[]=$ciclocobro;
        $ccobro[]=$ciclocobroant;
        $efectivo[]=$convercionefectivo;
        $efectivo[]=$convercionefectivoant;
        $ccapital[]=$capital;
        $ccapital[]=$capitalant;
        
        
        
        
       
        return $this->render('flujo',[
         'cinventario'=>$cinventario,
         'cpago'=>$cpago,
         'ccobro'=>$ccobro,
         'efectivo'=>$efectivo,
         'ccapital'=>$ccapital,
         'fecha'=>$fecha,   
            'periodo' => $periodo,
            'periodoant' => $periodoant,
        ]);
     
    
    }
    /**
     * Updates an existing GrupoCuenta model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
           if(Yii::$app->user->isGuest)
      {
        return $this->redirect(['site/index']);   
     }
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing GrupoCuenta model.
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
     * Finds the GrupoCuenta model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return GrupoCuenta the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GrupoCuenta::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
  static public function total($id,$mes,$anno) 
    {
//      $mes = substr($fecha, 5,2);
//      $anno = substr($fecha, 0,4);
      $total = \frontend\models\Saldo::find()->join('INNER JOIN','cuenta','saldo.cuentaid = cuenta.id')->where(['saldo.status'=>1,'cuenta.grupo_cuentaid'=>$id])->andWhere(['MONTH(saldo.fecha)'=>$mes,'YEAR(saldo.fecha)'=>$anno])->all();  
      $saldototal = 0;
      if($total)
      {
          foreach ($total as $key => $saldos) 
          {
           $saldototal += $saldos->saldo;
                   
          }
      
          return $saldototal;
       }else{
           return false;
       }
    }
    public static function cuentasefectosxpagar($mes,$anno) 
    {
        $saldo = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andwhere(['or', 'cuentaid=19', ['or', 'cuentaid=20']])->all();
        if($saldo)
        {
            $saldoTotal = 0;
            foreach ($saldo as $sal) 
            {
                $saldoTotal +=$sal->saldo;
            }
            $saldoTotal = $saldoTotal/1000;
            return $saldoTotal;
        }else{            return false;}
    }
    public static function cuentasefectosxcobrar($mes,$anno) 
    {
        $saldo = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andwhere(['or', 'cuentaid=3', ['or', 'cuentaid=4']])->all();
        if($saldo)
        {
            $saldoTotal = 0;
            foreach ($saldo as $sal) 
            {
                $saldoTotal +=$sal->saldo;
            }
            $saldoTotal = $saldoTotal/1000;
            return $saldoTotal;
        }else{            return false;}
    }
    public static function ciclopagos($mes,$anno) 
    {
     //$compras = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andWhere(['cuentaid'=>36])->one();
     $compras = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andWhere(['cuentaid'=>36])->one();
     $cyexp = GrupoCuentaController::cuentasefectosxpagar($mes, $anno); 
  
     if($compras && $cyexp)
      {
         $compras= ($compras->saldo+129800)/1000;
         $ciclopagos = $cyexp/($compras)*360;    
        return $ciclopagos;  
      }
      else{return false;}
    }
    public static function capitaltrabajo($ciclopago,$cicloefectivo) 
    {
      if($ciclopago>$cicloefectivo)
      {
          $capital = 0;
      }else{
          $capital = $cicloefectivo-$ciclopago;      
                  
      }
      return $capital;
    }
    public static function cicloconversionefectivo($mes, $anno) 
    {
       return GrupoCuentaController::cicloinventario($mes, $anno)+GrupoCuentaController::ciclocobro($mes,$anno);   
    }
    
    public static function ciclocobro($mes, $anno) 
    {
       $empresa = \frontend\models\User::findOne(Yii::$app->user->getId())->entidad->id;
        $cyexp = GrupoCuentaController::cuentasefectosxcobrar($mes, $anno);  
       $ventas = SaldoController::ventasnetas($anno, $mes, $empresa)/1000;
       if($cyexp && $ventas)
       {
           $ciclocobros = ($cyexp/$ventas)*360;
           return $ciclocobros;
       }else{return false;}
       
    }
    public static function promedioinventario($mes, $anno) 
    {
      $inventario = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andwhere(['or', 'cuentaid=9', ['or', 'cuentaid=34']])->all();
        if($inventario )
        {
            $saldoinv = 0;
            foreach ($inventario as $inv) 
            {
             $saldoinv += $inv->saldo;    
            }
            if($saldoinv!=0)
            {
              $saldoinv = $saldoinv/1000;  
            }
        return $saldoinv;
        }else{
            return false;
        } 
    }
    public static function costoventas($mes, $anno) 
    {
       $costo = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andWhere(['cuentaid'=>36])->all();
      
        if($costo)
        {
            $costoventa = 0;
            foreach ($costo as $value) 
            {
             $costoventa += $value->saldo;  
             
            }
            return $costoventa;
        }else{
           return false;
        }  
    }
    public static function cicloinventario($mes, $anno) 
    {
      $promedioinventario = GrupoCuentaController::promedioinventario($mes, $anno);
      $costoventas = GrupoCuentaController::costoventas($mes, $anno);
      $cicloinventario = 0;  
       
      if($promedioinventario && $costoventas)
      {
          $cicloinventario = ($promedioinventario/($costoventas/1000))*360;
          
                  return $cicloinventario;
                  
      }else{
          return false;
      }
              
    }
    
    public static function endeudamiento($mes, $anno) 
    {
     
     
     $pasivototal = GrupoCuentaController::saldoxgrupogeneral(3, $mes, $anno)/1000;    
     $patrimoniototal = GrupoCuentaController::saldoxgrupogeneral(2, $mes, $anno)/1000;    
    if($pasivototal && $patrimoniototal)
    {
        $endeudamiento = ($pasivototal/($pasivototal+$patrimoniototal));
        return $endeudamiento;
    }else{return false;}
    }
    
    public static function saldoxgrupogeneral($idgrupogeneral,$mes,$anno) 
    {
     $saldos = \frontend\models\Saldo::find()->join('INNER JOIN', 'cuenta', 'saldo.cuentaid=cuenta.id')->join('INNER JOIN', 'grupo_cuenta', 'cuenta.grupo_cuentaid=grupo_cuenta.id')->join('INNER JOIN','grupo_general' , 'grupo_generalid=grupo_general.id')->where(['saldo.status'=>1,'YEAR(saldo.fecha)'=>$anno,'MONTH(saldo.fecha)'=>$mes])->andWhere(['grupo_general.id'=>$idgrupogeneral])->all();
     if($idgrupogeneral!=1)
     {  
     if($saldos)
     {
         $saldogeneral = 0;
         foreach ($saldos as $sal) 
         {
          $saldogeneral += $sal->saldo;    
         }
         return $saldogeneral;
         
         }else{
             return false;
         }
    }else{
        if($saldos)
     {
         $saldogeneral = 0;
         $saldoAF = 0;
         $count = 0;
         foreach ($saldos as $sal) 
         {
             if($sal->cuenta->grupo_cuentaid ==3)
             {
                 if($count ==0)
                 {
                  $saldoAF= $sal->saldo;  
                  $count++;
                     
                 }else{
                   $saldoAF-= $sal->saldo; 
                 }
                 
             }else{
                 
             $saldogeneral += $sal->saldo;    
             }
          
         }
         return $saldogeneral+$saldoAF;
         
         }else{
             return false;
         }
        
    }
    }
    
    static public function autonomia($mes , $anno) 
    {
     $pasivototal = GrupoCuentaController::saldoxgrupogeneral(3, $mes, $anno)/1000;    
     $patrimoniototal = GrupoCuentaController::saldoxgrupogeneral(2, $mes, $anno)/1000;    
    if($pasivototal && $patrimoniototal)
    {
        $autonomia = ($patrimoniototal/($pasivototal+$patrimoniototal))*100;
        return $autonomia;
    }else{return false;}   
    }
    
    static public function calidaddeuda($mes,$anno) 
    {
     $pasivocirc = GrupoCuentaController::total(6, $mes, $anno)/1000; 
     $pasivototal = GrupoCuentaController::saldoxgrupogeneral(3, $mes, $anno)/1000;
     if($pasivocirc&&$pasivototal)
     {
         $calidaddeuda = ($pasivocirc/$pasivototal)*100;
         return $calidaddeuda;
     }else{return false;}
    }
    public static function solvencia($mes,$anno) 
    {
     
     $activototal = GrupoCuentaController::saldoxgrupogeneral(1, $mes, $anno)/1000;
     $pasivototal = GrupoCuentaController::saldoxgrupogeneral(3, $mes, $anno)/1000;
     if($activototal&&$pasivototal)
     {
         $solvencia = ($activototal/$pasivototal)*100;
         return $solvencia;
     }else{return false;}
    }
    
    static public function liquidez($mes,$anno) 
    {
      $AC = GrupoCuentaController::total(1,$mes,$anno)/1000;
      $PC = GrupoCuentaController::total(6, $mes, $anno)/1000; 
      if($PC==0)
      {
          $liquidez = 0;
      }else{
          
      
      $liquidez = $AC/$PC;
      }
      return $liquidez;
    }
    static public function disponibilidad($mes,$anno) 
    {
      $AC = GrupoCuentaController::total(1,$mes,$anno)/1000;
      $PC = GrupoCuentaController::total(6, $mes, $anno)/1000; 
      $dispon = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andwhere(['or', 'cuentaid=1', ['or', 'cuentaid=2']])->all();
        
     if($dispon)
        {
           $saldodisp = 0;
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
        {$disp = 0;}
        else{
            
            $disp = $saldodisp/$PC;
        }
        
      return $disp;
    }
    static public function liquidezim($mes,$anno) 
    {
      $AC = GrupoCuentaController::total(1,$mes,$anno)/1000;
      $PC = GrupoCuentaController::total(6, $mes, $anno)/1000; 
      $inventario = \frontend\models\Saldo::find()->where(['status'=>1,'MONTH(fecha)'=>$mes,'YEAR(fecha)'=>$anno])->andwhere(['or', 'cuentaid=9', ['or', 'cuentaid=34']])->all();
       $saldoinv = 0; 
      if($inventario)
        {
          $saldoinv = 0;
            foreach ($inventario as $inv) 
            {
             $saldoinv += $inv->saldo;    
            }
            if($saldoinv!=0)
            {
              $saldoinv = $saldoinv/1000;  
            }
        }
      if($PC==0)
      {
          $liquidezim = 0;
      }else{
          
      
       $liquidezim = ($AC-$saldoinv)/$PC;
      }
      return $liquidezim;
    }
    static public function rentabilidad($mes,$anno,$empresa) 
    {
      $Utilidad= SaldoController::UtilidadPeriodo($anno, $mes, $empresa)/1000;
      $ventas = SaldoController::ventasnetas($anno, $mes, $empresa)/1000;
        
      if($Utilidad==0)
      {
          $rentabilidad = 0;
      }else{
          
      
      $rentabilidad = $Utilidad/$ventas;
      }
      return $rentabilidad;
    }
}
