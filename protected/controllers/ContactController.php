<?php

class ContactController extends RestController
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
			array('allow', // allow authenticated user to perform the below listed actions
				'actions'=>array('index','view','create','update','admin','delete','list','export'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Contact;
        $model->user_id = Yii::app()->user->id;
        $companies = Company::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Contact']))
		{
			$model->attributes=$_POST['Contact'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
			'companies'=>$companies,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
        $companies = Company::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Contact']))
		{
			$model->attributes=$_POST['Contact'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
			'companies'=>$companies,
		));
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
        $criteria = new CDbCriteria;
        $criteria->compare('user_id',Yii::app()->user->id);
        $contact=new Contact;
        $loggedInUserId = Yii::app()->user->id;
        $contact->user_id = $loggedInUserId;
        $company = new Company;
        $contacts = Contact::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
        $companies = Company::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($contact);

        if(isset($_POST['Contact']))
        {
            $contact->attributes=$_POST['Contact'];
            $company->attributes= $_POST['Company'];
            $companyName = $company->name;
            $company = Company::model()->findByAttributes(array('name'=>$company->name,'user_id'=>$loggedInUserId));
            if(!isset($company)){
                $company = new Company;
                $company->name = $companyName;
                $company->user_id = Yii::app()->user->id;
                $company->save();
            }
            $contact->company_id = $company->id;
            if($contact->save())
                $this->sendResponse(200);
            else
                $this->sendResponse(400);
        }
		$this->render('index',array('contact'=>$contact,'company'=>$company,'contacts'=>$contacts,'companies'=>$companies));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Contact('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Contact']))
			$model->attributes=$_GET['Contact'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

    /**
     * Fetches JSON data
     */
    public function actionList()
    {
        $results = array();
        $criteria = new CDbCriteria;
        $field = strtolower($_GET['field']);
        if($field!='id'){
            $criteria->addSearchCondition('user_id',Yii::app()->user->id);
            $criteria->compare('lower('. $field .')',strtolower($_GET['query']),true);
            $criteria->limit = 8;
            $criteria->order = $field.' asc';
        }
        $records = Contact::model()->findAll($criteria);

        if(!isset($records))
            $records = array();
        foreach($records as $value){
            array_push($results,$value->$field);
        }
        echo CJSON::encode($results);
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Contact::model()->findByAttributes(array('id'=>$id,'user_id'=>Yii::app()->user->id));
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='contact-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
