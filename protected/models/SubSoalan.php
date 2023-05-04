<?php

/**
 * This is the model class for table "socdb.sub_soalan".
 *
 * The followings are the available columns in table 'socdb.sub_soalan':
 * @property integer $id
 * @property integer $id_soalan
 * @property string $soalan
 */
class SubSoalan extends CActiveRecord
{
    var $id_bahagian = '';
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return SubSoalan the static model class
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
		return 'socdb.sub_soalan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_soalan, soalan', 'required', 'message' => '{attribute} perlu dilengkapkan.'),
			array('id, id_soalan, id_bahagian', 'numerical', 'integerOnly'=>true),
			array('soalan', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_soalan, id_bahagian, soalan', 'safe', 'on'=>'search'),
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
			'soalan' => array(self::BELONGS_TO, 'Majlis', 'id_soalan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_soalan' => 'Id Soalan',
			'soalan' => 'Soalan',
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
		$criteria->compare('id_soalan',$this->id_soalan);
		$criteria->compare('soalan',$this->soalan,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getSubSoalan($id)
    {
        $this->getDbCriteria()->mergeWith(array(
                'condition' => "id_soalan = :id_soalan",
                'params' => array(':id_soalan' => $id),
            ));
        
        return $this;
    }
}