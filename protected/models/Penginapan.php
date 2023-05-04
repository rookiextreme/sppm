<?php

/**
 * This is the model class for table "socdb.penginapan".
 *
 * The followings are the available columns in table 'socdb.penginapan':
 * @property integer $id
 * @property integer $id_majlis
 * @property string $penginapan
 * @property integer $is_bin
 */
class Penginapan extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Penginapan the static model class
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
		return 'socdb.penginapan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_majlis, is_bin', 'numerical', 'integerOnly'=>true),
			array('id_majlis, penginapan','required'),
			array('penginapan', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_majlis, penginapan, is_bin', 'safe', 'on'=>'search'),
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
		'majlis' => array(self::BELONGS_TO, 'Majlis', 'id_majlis'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_majlis' => 'Majlis',
			'penginapan' => 'Nama Penginapan',
			'is_bin' => 'Is Bin',
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
		$criteria->compare('id_majlis',$this->id_majlis);
		$criteria->compare('penginapan',$this->penginapan,true);
		$criteria->compare('is_bin',$this->is_bin);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	public function getList($id_majlis=null)
    {
        if($id_majlis) {
            $this->getDbCriteria()->mergeWith(array(
                'condition' => 'id_majlis = :id_majlis',
                'params' => array(':id_majlis' => $id_majlis),
                'order'=>'id',
            ));
            return $this;
        }
    }
}