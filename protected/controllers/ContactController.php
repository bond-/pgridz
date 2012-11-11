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
                'actions'=>array('index','view','create','update','export','admin','delete','list','viewPartial'),
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
        $contact = $this->loadModel($id);
        $loggedInUserId = Yii::app()->user->id;
        $company = $contact->company;

        // Uncomment the following line if AJAX validation is needed
        //$this->performAjaxValidation($model);

        if(isset($_POST['Contact']))
        {
            $contact->attributes=$_POST['Contact'];
            $companyName = $_POST['Company']['name'];
            $company = Company::model()->findByAttributes(array('name'=> $companyName,'user_id'=>$loggedInUserId));
            if(!isset($company)){
                $company = new Company;
                $company->name = $companyName;
                $company->user_id = $loggedInUserId;
                $company->save();
            }
            $contact->company_id = $company->id;
            if($contact->save())
                $this->sendResponse(200);
            else
                $this->sendResponse(400,$companyName);
        }

        $this->render('update',array(
            'contact'=>$contact,
            'company'=>$company,
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
        $contact=new Contact;
        $loggedInUserId = Yii::app()->user->id;
        $contact->user_id = $loggedInUserId;
        $company = new Company;

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
        $this->render('index',array('contact'=>$contact,'company'=>$company,));
    }

    public function actionViewPartial(){
        if(isset($_POST['view'])){
            $view = $_POST['view'];
            $data = array();
            $attributes = array('user_id' => Yii::app()->user->id);
            if($view=="contacts"){
                if(isset($_POST['id'])){
                    $attributes['company_id']=(int)($_POST['id']);
                }
                $data = Contact::model()->findAllByAttributes($attributes);
            }elseif($view=="companies"){
                if(isset($_POST['id'])){
                    $attributes['id']=(int)($_POST['id']);
                }
                $data = Company::model()->findAllByAttributes($attributes);
            }elseif($view=="analysis"){
                if(isset($_POST['id']))
                    $data = array('id'=>(int)($_POST['id']));
            }
            $this->renderPartial('_'.$view,array($view=>$data));
        }else{
            $this->sendResponse(400);
        }
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

    public function actionExport()
    {
        $companyId=null;
        if(isset($_GET['id'])){
            $companyId= $_GET['id'];
        }
        $pdf = Yii::createComponent('application.extensions.tcpdf.ETcPdf',
            'L', 'cm', 'A4', true, 'UTF-8');
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor("powergridz.com");
        $pdf->SetTitle("Contact Export");
        $pdf->SetSubject("Contacts");
        $pdf->SetKeywords("Powergridz, PDF, export, contacts");
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        $pdf->writeHTML('<h1>'.Yii::app()->name.'</h1><br/><br/>', true, false, false, false, '');

        $pdf->writeHTML($this->getPDFContent($companyId), true, false, false, false, '');

        $pdf->Output("contacts-export-".gmdate("d-m-Y").".pdf", "I");

    }

    private function getPDFContent($companyId){

        $companies = isset($companyId)?array(Company::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'id'=>$companyId))):
            Company::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id));
        $content = '';
        foreach($companies as $company){
            $contacts=Contact::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id,'company_id'=>$company->id));
            if(!sizeof($contacts)==0){
                $tblHead = <<<EOD
                <h1>Company : $company->name</h1>
            <table cellspacing="0" cellpadding="1" border="1">
                <tr>
                    <th>Name</th>
                    <th>Title</th>
                    <th>Group</th>
                    <th>City</th>
                    <th>Country</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>School</th>
                    <th>Notes</th>
                    <th>Questions</th>
                    <th>IQ</th>
                    <th>Like</th>
                </tr>
EOD;
                $tblFooter = <<<EOD
                </table>
                <br/><br/>
EOD;
                $tblBody ='';
                foreach($contacts as $it){
                    $tblBody .= <<<EOD
                <tr>
                    <td>$it->name</td>
                    <td>$it->title</td>
                    <td>$it->group_division</td>
                    <td>$it->city</td>
                    <td>$it->country</td>
                    <td>$it->phone</td>
                    <td>$it->email</td>
                    <td>$it->school</td>
                    <td>$it->notes</td>
                    <td>$it->questions_to_ask</td>
                    <td>$it->iq</td>
                    <td>$it->c_like</td>
                </tr>
EOD;
                }
                $content.=$tblHead.$tblBody.$tblFooter;
            }

        }
        return $content;
    }
}
