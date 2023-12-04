<?php

namespace frontend\controllers;

use frontend\models\Ratio;
use frontend\models\RatioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

/**
 * RatioController implements the CRUD actions for Ratio model.
 */
class RatioController extends Controller
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
     * Lists all Ratio models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new RatioSearch();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Ratio model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionViewvalor($id,$fecha,$periodo)
    {
        $model = Ratio::find()->where(['id'=>$id])->one();
        if($model)
        {
            
        $valor = $this->buscarmesesanteriores($id, $fecha);
        $periodos['1'] = $periodo;
        $fechas = SaldoController::fechaperiodoanterior($fecha);
        $periodos['2'] = SaldoController::meses($fechas['mes']).'/'.$fechas['anno'];
       $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
        $periodos['3'] = SaldoController::meses($fechas['mes']).'/'.$fechas['anno'];
        return $this->render('viewvalor', [
            'model' => $model,
            'valor'=>$valor,
            'periodo'=>$periodos,
            
            'fecha'=>$fecha,
        ]);
        }else{
            return $this->redirect(['grupo-cuenta/razones']);
        }
    }

    /**
     * Creates a new Ratio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Ratio();

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

    /**
     * Updates an existing Ratio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Ratio model.
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
     * Finds the Ratio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Ratio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ratio::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    public function buscarmesesanteriores($id,$fecha) 
    {
        switch ($id) {
            case 1:
                $valor['1'] =\Yii::$app->formatter->asCurrency( GrupoCuentaController::liquidez(substr($fecha,5,2), substr($fecha,0,4)));
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->asCurrency(GrupoCuentaController::liquidez(($fechas['mes']),$fechas['anno']));
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->asCurrency( GrupoCuentaController::liquidez(($fechas['mes']),$fechas['anno']));
                return $valor;
                break;
            case 2:
                $valor['1'] =\Yii::$app->formatter->asCurrency( GrupoCuentaController::liquidezim(substr($fecha,5,2), substr($fecha,0,4)));
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->asCurrency(GrupoCuentaController::liquidezim(($fechas['mes']),$fechas['anno']));
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->asCurrency( GrupoCuentaController::liquidezim(($fechas['mes']),$fechas['anno']));
                return $valor;
                break;
            case 3:
                $valor['1'] =\Yii::$app->formatter->asCurrency(GrupoCuentaController::disponibilidad (substr($fecha,5,2), substr($fecha,0,4)));
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->asCurrency(GrupoCuentaController::disponibilidad(($fechas['mes']),$fechas['anno']));
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->asCurrency( GrupoCuentaController::disponibilidad(($fechas['mes']),$fechas['anno']));
                return $valor;
                break;
            case 4:
                $valor['1'] =\Yii::$app->formatter->asDecimal(GrupoCuentaController::ciclocobro (substr($fecha,5,2), substr($fecha,0,4)),1).' días';
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->asDecimal(GrupoCuentaController::ciclocobro(($fechas['mes']),$fechas['anno']),1).' días';
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->asDecimal( GrupoCuentaController::ciclocobro(($fechas['mes']),$fechas['anno']),1).' días';
                return $valor;
                break;
            case 5:
                $valor['1'] =\Yii::$app->formatter->asDecimal(GrupoCuentaController::ciclopagos (substr($fecha,5,2), substr($fecha,0,4)),1).' días';
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->asDecimal(GrupoCuentaController::ciclopagos(($fechas['mes']),$fechas['anno']),1).' días';
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->asDecimal( GrupoCuentaController::ciclopagos(($fechas['mes']),$fechas['anno']),1).' días';
                return $valor;
                break;
            case 6:
                $valor['1'] =\Yii::$app->formatter->asDecimal(GrupoCuentaController::cicloinventario (substr($fecha,5,2), substr($fecha,0,4)),1).' días';
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->asDecimal(GrupoCuentaController::cicloinventario(($fechas['mes']),$fechas['anno']),1).' días';
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->asDecimal( GrupoCuentaController::cicloinventario(($fechas['mes']),$fechas['anno']),1).' días';
                return $valor;
                break;
            case 7:
                $valor['1'] =\Yii::$app->formatter->format(GrupoCuentaController::endeudamiento (substr($fecha,5,2), substr($fecha,0,4)),['percent',2]);
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->format(GrupoCuentaController::endeudamiento(($fechas['mes']),$fechas['anno']),['percent',2]);
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->format( GrupoCuentaController::endeudamiento(($fechas['mes']),$fechas['anno']),['percent',2]);
                return $valor;
                break;
            case 8:
                $valor['1'] =\Yii::$app->formatter->format(GrupoCuentaController::autonomia(substr($fecha,5,2), substr($fecha,0,4))/100,['percent',2]);
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->format(GrupoCuentaController::autonomia(($fechas['mes']),$fechas['anno'])/100,['percent',2]);
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->format( GrupoCuentaController::autonomia(($fechas['mes']),$fechas['anno'])/100,['percent',2]);
                return $valor;
                break;
            case 9:
                $valor['1'] =\Yii::$app->formatter->format(GrupoCuentaController::calidaddeuda(substr($fecha,5,2), substr($fecha,0,4))/100,['percent',2]);
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->format(GrupoCuentaController::calidaddeuda(($fechas['mes']),$fechas['anno'])/100,['percent',2]);
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->format( GrupoCuentaController::calidaddeuda(($fechas['mes']),$fechas['anno'])/100,['percent',2]);
                return $valor;
                break;
            case 10:
                $valor['1'] =\Yii::$app->formatter->asCurrency(GrupoCuentaController::solvencia(substr($fecha,5,2), substr($fecha,0,4))/100);
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->asCurrency(GrupoCuentaController::solvencia(($fechas['mes']),$fechas['anno'])/100);
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->asCurrency( GrupoCuentaController::solvencia(($fechas['mes']),$fechas['anno'])/100);
                return $valor;
                break;
            case 11:
                $valor['1'] =\Yii::$app->formatter->format(GrupoCuentaController::rentabilidad(substr($fecha,5,2), substr($fecha,0,4),\frontend\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->entidad->id),['percent',2]);
                $fechas = SaldoController::fechaperiodoanterior($fecha);
                $valor['2'] = \Yii::$app->formatter->format(GrupoCuentaController::rentabilidad(($fechas['mes']),$fechas['anno'],\frontend\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->entidad->id),['percent',2]);
                $fechas = SaldoController::fechaperiodoanterior($fechas['anno'].'-'.SaldoController::corregirmes($fechas['mes']).'-15');
                $valor['3'] = \Yii::$app->formatter->format( GrupoCuentaController::rentabilidad(($fechas['mes']),$fechas['anno'],\frontend\models\User::find()->where(['id'=>Yii::$app->user->getId()])->one()->entidad->id),['percent',2]);
                return $valor;
                break;

            default:
                break;
        }   
    }
}
