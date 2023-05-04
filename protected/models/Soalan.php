<?php

/**
 * This is the model class for table "socdb.soalan".
 *
 * The followings are the available columns in table 'socdb.soalan':
 * @property integer $id
 * @property string $tajuk
 * @property string $allowed_peserta
 * @property string $tajuk_pilihan
 * @property string $pilihan
 * @property integer $susunan
 * @property integer $id_jenis
 */
class Soalan extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Soalan the static model class
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
		return 'socdb.soalan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tajuk', 'required', 'message' => '{attribute} perlu dilengkapkan.'),
			array('id, susunan, id_jenis', 'numerical', 'integerOnly'=>true),
			array('tajuk', 'length', 'max'=>255),
			array('allowed_peserta, tajuk_pilihan', 'length', 'max'=>100),
			array('pilihan', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tajuk, allowed_peserta, tajuk_pilihan, pilihan, susunan, id_jenis', 'safe', 'on'=>'search'),
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
			'jenissoalan' => array(self::BELONGS_TO, 'JenisSoalan', 'id_jenis'),
			'subsoalan' => array(self::HAS_MANY, 'SubSoalan', 'id_soalan'),
		);
	}
    
    public function scopes() {
        return array(
            'available' => array(
                'condition' => 't.is_bin = :is_bin OR t.is_bin IS NULL',
                'params' => array(':is_bin' => Utils::NOT_DELETED)
            ),
            'sorting' => array(
                'order' => 't.susunan',
            ),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tajuk' => 'Bahagian',
			'allowed_peserta' => 'Peserta yang dibenarkan',
			'tajuk_pilihan' => 'Tajuk Pilihan',
			'pilihan' => 'Pilihan',
			'susunan' => 'Susunan',
			'id_jenis' => 'Id Jenis',
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
		$criteria->compare('tajuk',$this->tajuk,true);
		$criteria->compare('allowed_peserta',$this->allowed_peserta,true);
		$criteria->compare('tajuk_pilihan',$this->tajuk_pilihan,true);
		$criteria->compare('pilihan',$this->pilihan,true);
		$criteria->compare('susunan',$this->susunan);
		$criteria->compare('id_jenis',$this->id_jenis);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function getFieldByID($id,$field=null) {
        if(!is_null($field)&&isset($id))
            return $this->findByPk($id)->$field;
    }
    
    public function getSoalan($id)
    {
        $this->getDbCriteria()->mergeWith(array(
                'condition' => "id_jenis = :id_jenis",
                'params' => array(':id_jenis' => $id),
            ));
        
        return $this;
    }
}