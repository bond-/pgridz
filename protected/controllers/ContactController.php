<?php

class ContactController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/column1';

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
                'actions'=>array('index','view','update','export','viewPartial','list','upload','delete'),
                'users'=>array('@'),
                'expression'=>'!User::model()->findByPk(Yii::app()->user->id)->getAccountLocked()',
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
    public function actionDelete()
    {
        $id = $_POST['id'];
        if(!$this->loadModel($id)->delete()){
            $this->sendResponse(400);
        }
        $this->sendResponse(200);
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
            $title = null;
            if($view=="contacts"){
                if(isset($_POST['id'])){
                    $attributes['company_id']=(int)($_POST['id']);
                    $title = Company::model()->findByAttributes(array('id'=>$attributes['company_id']))->name;
                }
                $data = Contact::model()->findAllByAttributes($attributes,array('order'=>'name asc'));
            }elseif($view=="companies"){
                if(isset($_POST['id'])){
                    $attributes['id']=(int)($_POST['id']);
                    $title = Company::model()->findByAttributes(array('id'=>$attributes['id']))->name;
                }
                $data = Company::model()->findAllByAttributes($attributes,array('order'=>'name asc'));
            }elseif($view=="analysis"){
                if(isset($_POST['id'])){
                    $data['id']=(int)($_POST['id']);
                    $title = Company::model()->findByAttributes(array('id'=>$data['id']))->name;
                }
                $data['smartest'] = array('sort'=>'iq','order'=>'desc');
                $data['likable'] = array('sort'=>'c_like','order'=>'desc');
                $data['combo'] = array('sort'=>array('iq','c_like'),'order'=>'desc');
            }
            $this->renderPartial('_'.$view,array($view=>$data,'title'=>$title));
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
    public function actionList($field,$query)
    {
        $criteria = new CDbCriteria;
        $criteria->compare('lower('.$field.')',strtolower($query),true);
        $criteria->limit = 8;
        $criteria->order = $field.' asc';
        $records = Contact::model()->with(array('user'=>array('joinType'=>'INNER JOIN','condition'=>'user.id='.Yii::app()->user->id)))->findAll($criteria);
        if(!isset($records))
            $records = array();
        $names = array();
        foreach($records as $value){
            array_push($names,$value->$field);
        }
        echo CJSON::encode($names);
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

        $pdf->writeHTML('<h1>'.Yii::app()->name.'</h1><br/><br/><h2>Exported by: '.CHtml::encode(Yii::app()->user->name).'</h2><br/>', true, false, false, false, '');

        $pdf->writeHTML($this->getPDFContent($companyId,$_GET['sort'],$_GET['order']), true, false, false, false, '');

        $pdf->Output("contacts-export-".gmdate("d-m-Y").".pdf", "I");

    }

    private function getPDFContent($companyId,$sort,$order){

        $companies = isset($companyId)?array(Company::model()->findByAttributes(array('user_id'=>Yii::app()->user->id,'id'=>$companyId))):
            Company::model()->findAllByAttributes(array('user_id'=>Yii::app()->user->id),array('order'=>'name asc'));
        $content = '';
        foreach($companies as $company){
            $criteria = new CDbCriteria;
            $criteria->addColumnCondition(array('user_id'=>Yii::app()->user->id,'company_id'=>$company->id));
            if(is_array($sort)){
                $criteria->order = '(IFNULL('.$sort[0].',0)+IFNULL('.$sort[1].',0)) '.$order;
            }else{
                $criteria->order = $sort.' '.$order;
            }
            $contacts=Contact::model()->findAll($criteria);
            if(!sizeof($contacts)==0){
                $companyName = CHtml::encode($company->name);
                $tblHead = <<<EOD
                <h2>Company : $companyName</h2>
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
                    $name = CHtml::encode($it->name);
                    $title = CHtml::encode($it->title);
                    $group_division = CHtml::encode($it->group_division);
                    $city = CHtml::encode($it->city);
                    $country = CHtml::encode($it->country);
                    $phone = CHtml::encode($it->phone);
                    $email = CHtml::encode($it->email);
                    $school = CHtml::encode($it->school);
                    $notes = CHtml::encode($it->notes);
                    $questions_to_ask = CHtml::encode($it->questions_to_ask);
                    $iq = CHtml::encode(isset($it->iq)?$it->iq:'-');
                    $like = CHtml::encode(isset($it->c_like)?$it->c_like:'-');
                    $tblBody .= <<<EOD
                <tr>
                    <td>$name</td>
                    <td>$title</td>
                    <td>$group_division</td>
                    <td>$city</td>
                    <td>$country</td>
                    <td>$phone</td>
                    <td>$email</td>
                    <td>$school</td>
                    <td>$notes</td>
                    <td>$questions_to_ask</td>
                    <td>$iq</td>
                    <td>$like</td>
                </tr>
EOD;
                }
                $content.=$tblHead.$tblBody.$tblFooter;
            }

        }
        return $content;
    }

    /**
     * For uploading excel files
     */
    public function actionUpload(){
        $model=new UploadForm;
        if(isset($_FILES['UploadForm']))
        {
            $this->loadPHPExcelLibrary();
            if(!$_FILES['UploadForm']['error']['file']>0){
                $fileName = $_FILES['UploadForm']['name']['file'];
                $reader = PHPExcel_IOFactory::createReader($this->getReaderType($fileName));
                $reader->setReadDataOnly(true);
                $file = $reader->load($_FILES["UploadForm"]["tmp_name"]["file"]);
                $objWorksheet = $file->setActiveSheetIndex(0);
                $highestRow = $objWorksheet->getHighestRow();
                $highestColumn = $objWorksheet->getHighestColumn();
                $errorsArray = array();
                if(strcmp(PHPExcel_Cell::stringFromColumnIndex(12),$highestColumn)!=0){
                    unlink($_FILES["UploadForm"]["tmp_name"]["file"]);
                    Yii::app()->user->setFlash('error',"Invalid format, Expecting columns: ".PHPExcel_Cell::stringFromColumnIndex(12).", Found ".$highestColumn." columns");
                    $this->render('upload',array('model'=>$model,'errors'=>$errorsArray));
                    Yii::app()->end();
                }
                for ($row = 1; $row <= $highestRow; ++$row) {
                    // Fetch the data of the columns you need
                    $col1 = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
                    $col2 = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
                    $col3 = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
                    $col4 = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
                    $col5 = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
                    $col6 = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
                    $col7 = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
                    $col8 = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
                    $col9 = $objWorksheet->getCellByColumnAndRow(8, $row)->getValue();
                    $col10 = $objWorksheet->getCellByColumnAndRow(9, $row)->getValue();
                    $col11 = $objWorksheet->getCellByColumnAndRow(10, $row)->getValue();
                    $col12 = $objWorksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $col13 = $objWorksheet->getCellByColumnAndRow(12, $row)->getValue();

                    $contact = $this->createContact(array(
                        'companyName'=>$col1,
                        'name'=>$col2,
                        'title'=>$col3,
                        'group_division'=>$col4,
                        'city'=>$col5,
                        'country'=>$col6,
                        'phone'=>$col7,
                        'email'=>$col8,
                        'school'=>$col9,
                        'notes'=>$col10,
                        'questions_to_ask'=>$col11,
                        'iq'=>$col12,
                        'c_like'=>$col13,
                    ));
                    $errors = $contact->getErrors();
                    if(!empty($errors)){
                        foreach($contact->attributeNames() as $attr){
                            $error = $contact->getError($attr);
                            if(isset($error)){
                                $contact->$attr = null;
                            }
                        }
                        $contact->save();
                        array_push($errorsArray,"Ignoring error in row ".$row.": ".CJSON::encode($errors));
                    }
                }
                $this->cleanupUploader($objWorksheet);
                if(empty($errorsArray)){
                    Yii::app()->user->setFlash('success','All the contacts have been uploaded successfully');
                }else{
                    Yii::app()->user->setFlash('warning','Oops, some contacts are uploaded ignoring certain fields and are listed below');
                }
                $this->render('upload',array('model'=>$model,'errors'=>$errorsArray));
            }else{
                Yii::app()->user->setFlash('error',"Error in upload");
            }
            Yii::app()->end();
        }
        $this->render('upload',array('model'=>$model));
    }

    private function loadPHPExcelLibrary(){
        // unregister Yii's autoloader
        spl_autoload_unregister(array('YiiBase', 'autoload'));
        // register PHPExcel's autoloader ... PHPExcel.php will do it
        $phpExcelPath = Yii::getPathOfAlias('ext');
        include($phpExcelPath . DIRECTORY_SEPARATOR . 'PHPExcel.php');
        // register Yii's autoloader again
        spl_autoload_register(array('YiiBase', 'autoload'));
    }

    private function cleanupUploader($worksheet){
        $worksheet->disconnectCells();
    }

    private function getReaderType($fileName = ""){
        $ext = strtolower(end(explode('.',$fileName)));
        switch($ext){
            case 'xlsx':
                return 'Excel2007';
            case 'ods':
                return 'OOCalc';
            case 'xls':
                return 'Excel5';
        }
        return null;
    }

    private function createContact($params){
        $user_id = Yii::app()->user->id;
        $criteria = new CDbCriteria();
        $criteria->addColumnCondition(array('lower(name)'=>strtolower($params['companyName'])));
        $criteria->addColumnCondition(array('user_id'=>Yii::app()->user->id));
        $company = Company::model()->find($criteria);
        if(!isset($company)){
            $company = new Company();
            $company->name = $params['companyName'];
            $company->user_id = $user_id;
            $company->save();
        }
        $contact = new Contact();
        $contact->setAttributes($params);
        $contact->user_id = $user_id;
        $contact->company_id = $company->id;
        $contact->save();
        return $contact;
    }
}
