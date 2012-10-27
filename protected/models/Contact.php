<?php

/**
 * This is the model class for table "contact".
 *
 * The followings are the available columns in table 'contact':
 * @property integer $id
 * @property integer $user_id
 * @property integer $company_id
 * @property string $name
 * @property string $title
 * @property string $group_division
 * @property string $city
 * @property string $country
 * @property string $phone
 * @property string $email
 * @property string $school
 * @property string $notes
 * @property string $questions_to_ask
 * @property integer $iq
 * @property integer $like
 *
 * The followings are the available model relations:
 * @property Company $company
 * @property User $user
 */
class Contact extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Contact the static model class
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
		return 'contact';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, company_id, name', 'required'),
			array('user_id, company_id, iq, like', 'numerical', 'integerOnly'=>true),
			array('name, title, group_division, city, country, phone, email, school', 'length', 'max'=>255),
			array('notes, questions_to_ask', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, company_id, name, title, group_division, city, country, phone, email, school, notes, questions_to_ask, iq, like', 'safe', 'on'=>'search'),
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
			'company' => array(self::BELONGS_TO, 'Company', 'company_id'),
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'company_id' => 'Company',
			'name' => 'Name',
			'title' => 'Title',
			'group_division' => 'Group Division',
			'city' => 'City',
			'country' => 'Country',
			'phone' => 'Phone',
			'email' => 'Email',
			'school' => 'School',
			'notes' => 'Notes',
			'questions_to_ask' => 'Questions To Ask',
			'iq' => 'Iq',
			'like' => 'Like',
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
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('company_id',$this->company_id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('group_division',$this->group_division,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('country',$this->country,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('school',$this->school,true);
		$criteria->compare('notes',$this->notes,true);
		$criteria->compare('questions_to_ask',$this->questions_to_ask,true);
		$criteria->compare('iq',$this->iq);
		$criteria->compare('like',$this->like);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}