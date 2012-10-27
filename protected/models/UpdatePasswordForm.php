<?php

class UpdatePasswordForm extends CFormModel{
    public $password;
    public $newPassword1;
    public $newPassword2;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // all fields are required
            array('password, newPassword1, newPassword2', 'required'),
            array('password', 'authenticate'),
            array('newPassword2', 'compare', 'compareAttribute'=>'newPassword1'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'currentPassword'=>'Current password',
            'newPassword1'=>'New password',
            'newPassword2'=>'Reenter new password',
        );
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $_identity=new UserIdentity(Yii::app()->user->name,$this->password);
            if(!$_identity->authenticate())
                $this->addError('password','Incorrect password');
        }
    }
}