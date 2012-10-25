<?php

/**
 * This is the model class for table "pg_user".
 *
 * The followings are the available columns in table 'pg_user':
 * @property integer $id
 * @property string $email
 * @property string $password
 * @property integer $city_id
 * @property integer $state_id
 * @property integer $country_id
 * @property string $zip
 * @property string $join_date
 * @property string $end_date
 * @property string $firm
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('email, password, join_date', 'required'),
			array('city_id, state_id, country_id', 'numerical', 'integerOnly'=>true),
			array('email, password, zip, firm', 'length', 'max'=>255),
			array('end_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, email, password, city_id, state_id, country_id, zip, join_date, end_date, firm', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'email' => 'Email',
			'password' => 'Password',
			'city_id' => 'City',
			'state_id' => 'State',
			'country_id' => 'Country',
			'zip' => 'Zip',
			'join_date' => 'Join Date',
			'end_date' => 'End Date',
			'firm' => 'Firm',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('state_id',$this->state_id);
		$criteria->compare('country_id',$this->country_id);
		$criteria->compare('zip',$this->zip,true);
		$criteria->compare('join_date',$this->join_date,true);
		$criteria->compare('end_date',$this->end_date,true);
		$criteria->compare('firm',$this->firm,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}
