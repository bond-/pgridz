<?php

class UserController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/main';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules()
    {
        return array(
            array('allow',  // allow all users to perform 'register' action
                'actions'=>array('register','verifyRegistration','forgotPassword'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform the below listed actions
                'actions'=>array('index','updatePassword','updateProfile','view','renderPartialView'),
                'users'=>array('@'),
            ),
            /*array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('@'),
            ),*/
            array('deny',  // deny all users
                'users'=>array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     */
    public function actionView()
    {
        $id = Yii::app()->user->id;
        if($id){
            $this->render('view',array(
                'model'=>$this->loadModel($id),
            ));
        }
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionRegister()
    {
        $model=new User;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);

        if(isset($_POST['RegistrationForm']))
        {
            $model->attributes=$_POST['RegistrationForm'];
            $model->join_date = gmdate("d/m/Y");
            $model->account_locked = true;
            $model->password=Yii::app()->hasher->hashPassword($model->password);
            $model->save();
            $registrationCode = new RegistrationCode();
            $registrationCode->token = md5( uniqid());
            $registrationCode->dateCreated = gmdate("d/m/Y");
            $registrationCode->user_id = $model->id;
            $registrationCode->save(true);
            $this->sendResponse(200);
        }
        $this->sendResponse(500);
        // display the login form
        $this->redirect('view');
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionUpdateProfile()
    {
        $id = Yii::app()->user->id;
        $model=$this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            if($model->save()){
                $this->sendResponse(200,CJSON::encode($model));
            }
            else{
                $this->sendResponse(500);
            }
        }
        $this->redirect('view');
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex()
    {
        $this->redirect(array('view'));
    }

    public function actionUpdatePassword()
    {
        $model=new UpdatePasswordForm;
        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='update-password-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['UpdatePasswordForm']))
        {
            $id = Yii::app()->user->id;
            $user = $this->loadModel($id);
            $model->attributes=$_POST['UpdatePasswordForm'];

            $_identity=new UserIdentity(Yii::app()->user->name,$model->password);
            if($_identity->authenticate()){
                $user->password = Yii::app()->hasher->hashPassword($model->newPassword1);
                if($user->save()){
                    $this->sendResponse(200,CJSON::encode($model));
                }
            }else{
                $this->sendResponse(400, "Current password is incorrect");
            }
        }
    }

    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model=new User('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['User']))
            $model->attributes=$_GET['User'];

        $this->render('admin',array(
            'model'=>$model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id)
    {
        $model=User::model()->findByPk($id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function getTabularFormTabs()
    {
        $tabs = array();
        $count = 0;
        $id = Yii::app()->user->id;
        $profileForm = $this->loadModel($id);
        $updateForm = new UpdatePasswordForm();
        $tabs[] = array(
            'active'=>$count++ === 0,
            'label'=>"Update password",
            'content'=>$this->renderPartial('_updatePassword', array('updateForm'=>$updateForm,'id'=>'updatePasswordFormId','tabHeader'=>"Update password"), true),
        );
        $tabs[] = array('label'=>'Profile', 'items'=>array(
            array('label'=>"View",'content'=>$this->renderPartial('_view', array('profileForm'=>$profileForm,'tabHeader'=>"View"), true)),
            array('label'=>"Edit",'content'=>$this->renderPartial('_edit', array('profileForm'=>$profileForm,'tabHeader'=>"Edit"), true)),
        ));
        return $tabs;
    }

    public function actionTest(){
        echo "HI";
    }

    public function actionVerifyRegistration(){

        $token = $_GET['t'];
        $registrationCode=RegistrationCode::model()->findByAttributes(array('token'=>$token));
        if (!$registrationCode->token) {
            echo "first";
        }

        $transaction = Yii::app()->db->beginTransaction();
        try {
            $user_id = $registrationCode->user_id;
            if(!$user_id){
            }
            $user = $this->loadModel($user_id);
            $user->account_locked = false;
            $user->save();
            $registrationCode->delete();
            // commit transactions now
            $transaction->commit();
        } catch (Exception $ex) {
            $transaction->rollback();
        }
    }

    public function actionForgotPassword(){

        $model=new ForgotPasswordForm();

        //*/ Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);
        try{
            if(isset($_POST['ForgotPasswordForm']))
            {
                $model->attributes=$_POST['ForgotPasswordForm'];
                $user=User::model()->findByAttributes(array('email'=>$model->email));
                if($user){
                    $registrationCode = new RegistrationCode();
                    $registrationCode->token = md5( uniqid());
                    $registrationCode->dateCreated = gmdate("d/m/Y");
                    $registrationCode->user_id = $model->id;
                    $registrationCode->save(true);
                    $this->sendResponse(200);
                }else{
                    $this->sendResponse(500, "User doesn't exist..!!");
                }
            }
        }catch (Exception $ex){
            echo "Ex".$ex;
        }
    }

    public function actionRenderPartialView(){
        $id = Yii::app()->user->id;
        $profileForm = $this->loadModel($id);
        $this->renderPartial('_view', array('profileForm'=>$profileForm,'tabHeader'=>"View"));
    }
    public function actionRenderPartialEdit(){
        $id = Yii::app()->user->id;
        $profileForm = $this->loadModel($id);
        $this->renderPartial('_edit', array('profileForm'=>$profileForm,'tabHeader'=>"View"));
    }

}
