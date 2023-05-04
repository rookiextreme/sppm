<?php

/**
 * This is the model class for table "socdb.pengganti".
 *
 * The followings are the available columns in table 'socdb.pengganti':
 * @property integer $id
 * @property string $nama_pengganti
 * @property string $email_pengganti
 * @property string $telefon_pengganti
 * @property integer $id_peserta_asal
 */
class Pengganti extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Pengganti the static model class
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
		return 'socdb.pengganti';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id', 'required'),
			array('id, id_peserta_asal', 'numerical', 'integerOnly'=>true),
			array('nama_pengganti, email_pengganti', 'length', 'max'=>100),
			array('telefon_pengganti', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nama_pengganti, email_pengganti, telefon_pengganti, id_peserta_asal', 'safe', 'on'=>'search'),
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
			'nama_pengganti' => 'Nama Pengganti',
			'email_pengganti' => 'Email Pengganti',
			'telefon_pengganti' => 'Telefon Pengganti',
			'id_peserta_asal' => 'Id Peserta Asal',
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
		$criteria->compare('nama_pengganti',$this->nama_pengganti,true);
		$criteria->compare('email_pengganti',$this->email_pengganti,true);
		$criteria->compare('telefon_pengganti',$this->telefon_pengganti,true);
		$criteria->compare('id_peserta_asal',$this->id_peserta_asal);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}