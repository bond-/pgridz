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
                'actions'=>array('register','forgotPassword','verifyRegistration','verifyResetPassword'),
                'users'=>array('*'),
            ),
            array('allow', // allow authenticated user to perform the below listed actions
                'actions'=>array('index','updatePassword','updateProfile','view','renderPartialView','renderPartialEdit'),
                'users'=>array('@'),
            ),
            /*array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions'=>array('admin','delete'),
                'users'=>array('@'),
            ),*/
            array('deny',  // deny all users
                'actions'=>array('generateVerificationCode','verify','generatePassword'),
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
        $user=new User;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);

        if(isset($_POST['RegistrationForm']))
        {
            $user->attributes=$_POST['RegistrationForm'];
            $isUserExist = User::model()->findByAttributes(array('email' => $user->email));
            if(!isset($isUserExist)){
                $user->join_date = gmdate("d/m/Y");
                $user->account_locked = true;
                $user->password=Yii::app()->hasher->hashPassword($user->password);
                $user->save();
                //sending registration mail
                $token = $this->generateVerificationCode($user->id);
                try{
                    $message = new YiiMailMessage;
                    $message->view = 'verifyRegistrationEmail';
                    $message->subject = "New account";
                    //userModel is passed to the view
                    $message->setBody(array(
                            'link'=>Yii::app()->createAbsoluteUrl("user/verifyRegistration",array('t'=>$token))),
                        'text/html');
                    $message->addTo($user->email);
                    $message->from = Yii::app()->params['adminEmail'];
                    Yii::app()->mail->send($message);
                    $this->sendResponse(200);
                }catch (Exception $e){
                    $this->sendResponse(503);
                }
            }else{
                $this->sendResponse(406, "Current password is incorrect");
            }
        }else{
            $this->sendResponse(500);
        }
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
    //To update password
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
    //To render tabs in profile
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

    /**
     * Registration verification
     */
    public function actionVerifyRegistration(){
        if(isset($_GET['t'])){
            $token = $_GET['t'];
            $user = $this->actionVerify($token);
            if($user!=null){
                Yii::app()->user->setFlash('success','Verification is successful. Please login to continue');
                $this->redirect(array('site/index'));
            }else{
                Yii::app()->user->setFlash('error','Verification is un-successful. Invalid code');
                $this->redirect(array('site/index'));
            }
        }else{
            Yii::app()->user->setFlash('error','Verification is un-successful. Invalid code');
            $this->redirect(array('site/index'));
        }
    }

    /**
     * Password reset verification
     */
    public function actionVerifyResetPassword(){
        if(isset($_GET['t'])){
            $token = $_GET['t'];
            $user = $this->actionVerify($token);
            if($user!=null){
                $generatedPassword = $this->generatePassword();
                $user->password=Yii::app()->hasher->hashPassword($generatedPassword);
                $user->save();
                try{
                    $message = new YiiMailMessage;
                    $message->view = 'passwordReset';
                    $message->subject = "Your new password";
                    //userModel is passed to the view
                    $message->setBody(array(
                            'password'=>$generatedPassword),
                        'text/html');
                    $message->addTo($user->email);
                    $message->from = Yii::app()->params['adminEmail'];
                    Yii::app()->mail->send($message);
                    Yii::app()->user->setFlash('success','New password has been sent to your email Id :'.$user->email);
                    $this->redirect(array('site/index'));
                }
                catch(Exception $e){
                    Yii::app()->user->setFlash('error','Unable to send email to : '.$user->email);
                }

            }else{
                Yii::app()->user->setFlash('error','Verification is un-successful. Invalid code');
                $this->redirect(array('site/index'));
            }
        }else{
            Yii::app()->user->setFlash('error','Verification is un-successful. Invalid code');
            $this->redirect(array('site/index'));
        }
    }
    /**
     * @param $token
     * @return CActiveRecord|null
     */
    private function actionVerify($token){
        $registrationCode=RegistrationCode::model()->findByAttributes(array('token'=>$token));
        if(!isset($registrationCode)){
            return null;
        }else{
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $user_id = $registrationCode->user_id;
                if(!$user_id){
                    return null;
                }
                $user = $this->loadModel($user_id);
                $user->account_locked = false;
                $user->save();
                //$registrationCode->delete();
                // commit transactions now
                $transaction->commit();
                return $user;
            } catch (Exception $ex) {
                $transaction->rollback();
                return null;
            }
        }
    }

    /**
     * To send an email to user with verification token
     */
    public function actionForgotPassword(){
        $model=new ForgotPasswordForm();
        if(isset($_POST['ForgotPasswordForm']))
        {
            $model->attributes=$_POST['ForgotPasswordForm'];
            $user=User::model()->findByAttributes(array('email'=>$model->email));
            if($user){
                //sending registration mail
                $token = $this->generateVerificationCode($user->id);
                try{
                    $message = new YiiMailMessage;
                    $message->view = 'verifyPasswordUpdateMail';
                    $message->subject = "Password reset";
                    //userModel is passed to the view
                    $message->setBody(array(
                            'link'=>Yii::app()->createAbsoluteUrl("user/verifyResetPassword",array('t'=>$token))),
                        'text/html');
                    $message->addTo($model->email);
                    $message->from = Yii::app()->params['adminEmail'];
                    $message->to = $user->email;
                    Yii::app()->mail->send($message);
                    $this->sendResponse(200);
                }catch (Exception $ex){
                    $this->sendResponse(503, "Unable to send email");
                }
            }else{
                $this->sendResponse(500, "User doesn't exist..!!");
            }
        }
    }

    //To render user details in view mode
    public function actionRenderPartialView(){
        $id = Yii::app()->user->id;
        $profileForm = $this->loadModel($id);
        $this->renderPartial('_view', array('profileForm'=>$profileForm,'tabHeader'=>"View"));
    }

    //To render user details in edit mode
    public function actionRenderPartialEdit(){
        $id = Yii::app()->user->id;
        $profileForm = $this->loadModel($id);
        $this->renderPartial('_edit', array('profileForm'=>$profileForm,'tabHeader'=>"Edit"));
    }

    /**
     * Generates new verification code
     * @param $id
     * @return string
     */
    private function generateVerificationCode($id){
        $registrationCode = new RegistrationCode();
        $registrationCode->token = md5( uniqid());
        $registrationCode->dateCreated = gmdate("d/m/Y");
        $registrationCode->user_id = $id;
        $registrationCode->save();
        return $registrationCode->token;
    }

    /**
     * Generates 9 length new password string
     * @param int $length
     * @param int $strength
     * @return string
     */
    private function generatePassword($length=9, $strength=0) {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }
        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }

}
