<?php

class ForgotPasswordForm extends CFormModel{
    public $email;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // all fields are required
            array('email','required'),
            array('email','checkdns'),
            array('email','emailExists'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email'=>'Email',
        );
    }

    /**
     * Checks if a DNS record exists for domain name in the user's email
     * This is the checkdns declared in rules()
     */
    public function checkdns(){
        if(!$this->hasErrors())
        {
            $domain = explode('@',$this->email,2);
            if(!checkdnsrr($domain[1],'MX')) {
                $this->addError('email','Invalid domain name: '.$domain[1]);
            }
        }
    }

    public function emailExists(){
        $user=User::model()->findByAttributes(array('email'=>$this->email));
        if(isset($user)){
            $this->addError('email','Email does not exist: '.$user);
        }
    }
}