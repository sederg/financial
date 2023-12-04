<?php

namespace frontend\controllers;

use Yii;
use common\models\User;
use frontend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\MethodNotAllowedHttpException;
use frontend\models\Trabajador;


/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        if(!UserController::permitido())
        {            
              throw new MethodNotAllowedHttpException('Debe tener permisos de administración para poder acceder a esta parte del sitio.');
        }
        else
        {
            if(Yii::$app->user->identity->rolid == 1)
            {
           $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['NOT',['status'=>0]])->andWhere(['NOT',['rolid'=>4]])->andWhere(['entidadid'=>\frontend\controllers\UserController::findModel(Yii::$app->user->getId())->entidad->id])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
            }    
       
          if(Yii::$app->user->identity->rolid == 4)
            {
           $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->/*andWhere(['NOT',['rolid'=>5]])->*/orderBy('entidadid')->all();

        return $this->render('indexS', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
            }    
       
            else{
           $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->query->andFilterWhere(['NOT',['status'=>0]])->andWhere(['entidadid'=>\frontend\controllers\UserController::findModel(Yii::$app->user->getId())->entidad->id])->all();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);      
            }
        }
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        
        if(!UserController::permitido())
        {
           throw new MethodNotAllowedHttpException('Debe tener permisos de administración para poder acceder a esta parte del sitio.');
          
        }
       
        else
        {
          
            $model=$this->findModel($id);
            $userupd = $model;
            $trabajador = TrabajadorController::findmodel(['iduser'=>$id]);
            $trabajadorupd = $trabajador;
 
        if ($model->load(Yii::$app->request->post()) || $trabajador->load(Yii::$app->request->post())) 
                {
             
            if($userupd->id == Yii::$app->user->getId() && $userupd->rolid == $model->rolid )
                {
                //return print_r('entro23');
                    if($userupd->updateAttributes(['username'=>$model->username]))

                    {
                    Yii::$app->session->setFlash('kv-detail-warning', 'Usted no puede modificar el rol de su propio usuario, los demas datos han sido guardados correctamente ');
                    // Multiple alerts can be set like below
                   // Yii::$app->session->setFlash('kv-detail-warning', 'A last warning for completing all data.');
                    //Yii::$app->session->setFlash('kv-detail-info', '<b>Note:</b> You can proceed by clicking <a href="#">this link</a>.');
                    return $this->redirect(['view', 'id'=>$model->id]);

                    }
                else{
                         Yii::$app->session->setFlash('kv-detail-danger', 'Error al guardar los datos ');
                        if(Yii::$app->user->identity->rolid == 4)
                        {
                            
                   return $this->redirect(['viewS', 'id'=>$model->id]);
                        }else{
                   return $this->redirect(['view', 'id'=>$model->id]);
                            
                        }
                    }
            }else{
                        /* $userupd->username = $model->username;
                         $userupd->direccionid = $model->direccionid;
                         $userupd->email = $model->email;
                         $userupd->rolid = $model->rolid;*/

                   if($userupd->updateAttributes(['username'=>$model->username,'rolid'=>$model->rolid,'entidadid'=>$model->entidadid]))

                {
                        Yii::$app->session->setFlash('kv-detail-success', 'Sus datos han sido guardados correctamente. ');
                        // Multiple alerts can be set like below
                       // Yii::$app->session->setFlash('kv-detail-warning', 'A last warning for completing all data.');
                        //Yii::$app->session->setFlash('kv-detail-info', '<b>Note:</b> You can proceed by clicking <a href="#">this link</a>.');
                       Yii::$app->db->createCommand("DELETE FROM `auth_assignment` WHERE `auth_assignment`.`user_id` = '".$model->id."'")->execute();
                       Yii::$app->db->createCommand("INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES ('".$model->rol->rol."', '".$model->id."', ". time().");")->execute();
                        return $this->redirect(['view', 'id'=>$model->id]);

                    }
                    else{

                        if($trabajadorupd->updateAttributes(['nombre'=>$trabajador->nombre,'primerApellido'=>$trabajador->primerApellido,'segundoApellido'=>$trabajador->segundoApellido,'CI'=>$trabajador->CI,'email'=>$trabajador->email,'telefono'=>$trabajador->telefono]))
                         {
                          $userupd->updateAttributes(['email'=>$trabajador->email]);  
                        Yii::$app->session->setFlash('kv-detail-success', 'Sus datos han sido guardados correctamente. ');
                    // Multiple alerts can be set like below
                   // Yii::$app->session->setFlash('kv-detail-warning', 'A last warning for completing all data.');
                    //Yii::$app->session->setFlash('kv-detail-info', '<b>Note:</b> You can proceed by clicking <a href="#">this link</a>.');
                        
                        if(Yii::$app->user->identity->rolid == 4)
                        {
                            
                   return $this->redirect(['viewS', 'id'=>$model->id]);
                        }else{
                   return $this->redirect(['view', 'id'=>$model->id]);
                            
                        }
                        }else {
             if(Yii::$app->user->identity->rolid == 4)
                        {
                            
                 return $this->render('viewS', ['model'=>$model,'trabajador'=>$trabajador]);
                        }else{
                 return $this->render('view', ['model'=>$model,'trabajador'=>$trabajador]);
                            
                        }
        }
                    }
            }
                }
         else {
             if(Yii::$app->user->identity->rolid == 4)
                        {
                            
                 return $this->render('viewS', ['model'=>$model,'trabajador'=>$trabajador]);
                        }else{
                 return $this->render('view', ['model'=>$model,'trabajador'=>$trabajador]);
                            
                        }
        }
        }
    
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      if(!UserController::permitido())
        {
           throw new MethodNotAllowedHttpException('Debe tener permisos de administración para poder acceder a esta parte del sitio.');
          
        }
        else
        {
        $model = new User();
        $trabajador = new Trabajador();
        if(Yii::$app->request->isAjax && ($trabajador->load($_POST)))
        {
            Yii::$app->response->format =   'json';
            return \kartik\form\ActiveForm::validate($trabajador);
        }

        
        if ($model->load(Yii::$app->request->post())&& $trabajador->load(Yii::$app->request->post()))
        {
           
               
            $model->setPassword($model->password_hash);
            $model->generateAuthKey();
            
            //$model->password = NULL;
        
            if($model->validate()&&$trabajador->validate())
            {
                $model->email = $trabajador->email;
            if($model->save())
            {
               Yii::$app->db->createCommand("INSERT INTO `auth_assignment` (`item_name`, `user_id`, `created_at`) VALUES ('".$model->rol->rol."', '".$model->id."', ". time().");")->execute();
                      
              $trabajador->iduser = $model->id; 
             // return print_r($trabajador);
              if($trabajador->save())
              {
                  $model->updateAttributes(['trabajadorid'=>$trabajador->id]);
                  // return print_r($trabajador);
             return $this->redirect(['view', 'id' => $model->id]);   
              }
             
              }
            }else{
                Yii::$app->session->setFlash("error_validacion"); 
                $model->password = "";
                $model->password_hash = "";
                return $this->render('create', [
            'model' => $model,
            'trabajador' => $trabajador,
        ]);
            }
              }
            
        
        }
        return $this->render('create', [
            'model' => $model,
            'trabajador' => $trabajador,
        ]);
    }
    
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionActivar($id)
    {
        $model = $this->findModel($id);

        if ($model) 
        {
        $model->updateAttributes(['status'=>10]);
        $_SESSION['user'] = $model->username;
        Yii::$app->session->setFlash("ok_activado");
        return $this->redirect(['user/index']);
        }

        return $this->redirect(['user/index']);
    }
    public function actionDesactivar($id)
    {
        $model = $this->findModel($id);

        if ($model) 
        {
            if($model->id != Yii::$app->user->identity->getId())
            {
        $model->updateAttributes(['status'=>9]);
        $_SESSION['user'] = $model->username;
        Yii::$app->session->setFlash("ok_desactivado");
        return $this->redirect(['user/index']);
            }
        Yii::$app->session->setFlash("usuario_propio");
        return $this->redirect(['user/index']);
        
            }

        return $this->redirect(['user/index']);
    }
    
    public function actionPassword($id)
    {
       if(\Yii::$app->user->getId() != $id)
       {
        if(!UserController::permitido())
        {
         
          throw new MethodNotAllowedHttpException('Usted solo puede cambiar la contraseña de su usuario o ser Administrador del sitio.');   
        }else{
                $model = $this->findModel($id);
                $model->password_hash = NULL;
                if($model->load(Yii::$app->request->post())) 
                    {
                    $model->setPassword($model->password_hash);
                    $model->generateAuthKey();
                    if( $model->save())
                        {
                        $_SESSION['user'] = $model->username;
                        Yii::$app->session->setFlash("ok_contraseña"); 
                        return $this->redirect(['/site/index']);
                        }
            
                    }
                    return $this->render('update', [
                    'model' => $model,
                                        ]);
    
            }
            
       }else{
        $model = $this->findModel($id);
        $model->password_hash = NULL;

        if ($model->load(Yii::$app->request->post())) 
            {
             $model->setPassword($model->password_hash);
            $model->generateAuthKey();
            if( $model->save())
            {
            $_SESSION['user'] = $model->username;
            Yii::$app->session->setFlash("ok_contraseña"); 
            return $this->redirect(['/site/index']);
        }
            
            }

        return $this->render('update', [
            'model' => $model,
        ]);
    
        }
       }
    public function actionDesconectar($id)
    {
      
        if(!UserController::permitido())
        {
         
          throw new MethodNotAllowedHttpException('Usted no tine permisos para realizar esta acción.');   
        }else{
             if(\Yii::$app->user->getId() != $id)
       {
                $model = $this->findModel($id);
                $model->updateAttributes(['conectado'=>0]);
                    return $this->redirect('index');
    
        } else{
            return $this->redirect('index');
        }
        
       }
            
      
        }
       

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
    if(!UserController::permitido())
        {
                     
              throw new MethodNotAllowedHttpException('Debe tener permisos de administración para poder eliminar un usuario.');
        }
        else
        {
        $this->findModel($id)->updateAttributes(['status' => 0]) ;

        return $this->redirect(['index']);
        }
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public static function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
    
    public function buscarpresidente() 
    {
         if (($model = User::findOne(['rolid'=> 5,'status'=>10])) !== null) {
            return true;
        }
    else{
        return false;
        
    }
         
        
    }
    
   
      public static function IsConnected($username)
    {
       $user = User::findByUsername($username);
       if($user->rolid == 2)
       {
           return false;
       }
       if($user->conectado == 1)
       {
        
         return TRUE;       
       } else{
           return FALSE;
    }
    }
    public static function permitido() 
    {
    $flag = true;
    $flag1 = true;
        if(\Yii::$app->user->isGuest||\Yii::$app->user->identity->rolid != 1)
        {
            $flag = false;
        }
        if(\Yii::$app->user->isGuest||\Yii::$app->user->identity->rolid != 4)
        {
            $flag1 = false;
        }
        if($flag1==$flag)
        {
        return false;
          
        }else{
            return true;
        }    
    }
    

}
