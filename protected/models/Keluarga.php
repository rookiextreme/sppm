<?php

/**
 * This is the model class for table "socdb.keluarga".
 *
 * The followings are the available columns in table 'socdb.keluarga':
 * @property integer $id
 * @property integer $id_peserta
 * @property string $nama
 * @property integer $umur
 * @property string $jantina
 */
class Keluarga extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Keluarga the static model class
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
		return 'socdb.keluarga';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_peserta, umur, hubungan', 'numerical', 'integerOnly'=>true),
			array('nama', 'length', 'max'=>100),
			array('jantina', 'length', 'max'=>1),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_peserta, nama, umur, hubungan, jantina', 'safe', 'on'=>'search'),
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
			'id_peserta' => 'Id Peserta',
			'nama' => 'Nama',
			'umur' => 'Umur',
			'jantina' => 'Jantina',
			'hubungan' => 'Hubungan',
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
		$criteria->compare('id_peserta',$this->id_peserta);
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('umur',$this->umur);
		$criteria->compare('jantina',$this->jantina,true);
		$criteria->compare('hubungan',$this->hubungan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}