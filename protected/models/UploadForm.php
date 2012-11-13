<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class UploadForm extends CFormModel
{
	public $file;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
            array('file', 'required'),
            array('file', 'fileValidator', 'types'=>'xls, xlsx, ods'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'file'=>'Upload contacts',
		);
	}

    public function fileValidator() {
        $validator = new CFileValidator;
        $validator->attributes = array('file');
        $validator->types = array('xls', 'xlsx', 'ods');
        if(!$validator->validate($this)) {
            $this->addError('file','Invalid format, use xls, xlsx, ods files');
        }
    }
}
