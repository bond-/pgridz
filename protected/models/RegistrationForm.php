<?php

class RegistrationForm extends CFormModel{
    public $email;
    public $password;
    public $password2;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return array(
            // all fields are required
            array('email, password, password2', 'required'),
            array('email', 'unique'),
            array('password2', 'compare', 'compareAttribute'=>'password'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return array(
            'email'=>'Email',
            'password'=>'Password',
            'password2'=>'Re-enter password',
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
}