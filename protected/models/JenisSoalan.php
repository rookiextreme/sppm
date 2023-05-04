<?php

/**
 * This is the model class for table "socdb.jenis_soalan".
 *
 * The followings are the available columns in table 'socdb.jenis_soalan':
 * @property integer $id    
 * @property string $tajuk_soalan
 * @property integer $pembentangan
 * @property string $allowed_peserta_pembentangan
 * @property integer $ulasan
 * @property integer $cadangan
 */
class JenisSoalan extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return JenisSoalan the static model class
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
		return 'socdb.jenis_soalan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tajuk_soalan', 'required', 'message' => '{attribute} perlu dilengkapkan.'),
			array('id, ulasan, cadangan', 'numerical', 'integerOnly'=>true),
			array('tajuk_soalan', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tajuk_soalan, ulasan, cadangan, is_bin', 'safe', 'on'=>'search'),
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
			'soalan' => array(self::HAS_MANY, 'Soalan', 'id_jenis', 'order' => 'susunan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tajuk_soalan' => 'Tajuk Penilaian',
			'ulasan' => 'Ulasan',
			'cadangan' => 'Cadangan',
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
		$criteria->compare('tajuk_soalan',$this->tajuk_soalan,true);
		$criteria->compare('ulasan',$this->ulasan);
		$criteria->compare('cadangan',$this->cadangan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getFieldByID($id,$field=null) {
        if(!is_null($field)&&isset($id))
            return $this->findByPk($id)->$field;
    }
}