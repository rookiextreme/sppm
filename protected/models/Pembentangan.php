<?php

/**
 * This is the model class for table "socdb.pembentangan".
 *
 * The followings are the available columns in table 'socdb.pembentangan':
 * @property integer $id
 * @property string $tajuk
 * @property integer $id_jadual
 *
 * The followings are the available model relations:
 * @property Jadual $idJadual
 */
class Pembentangan extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'socdb.pembentangan';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_majlis', 'numerical', 'integerOnly'=>true),
			array('tajuk', 'length', 'max'=>255),
			array('tajuk', 'required', 'message' => '{attribute} perlu dilengkapkan.'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tajuk, id_majlis', 'safe', 'on'=>'search'),
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
    
    public function scopes() {
        return array(
            'available' => array(
                'condition' => 'is_bin = :is_bin OR is_bin IS NULL',
                'params' => array(':is_bin' => Utils::NOT_DELETED)
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
			'tajuk' => 'Tajuk',
			'id_majlis' => 'Id Majlis',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('tajuk',$this->tajuk,true);
		$criteria->compare('id_majlis',$this->id_majlis);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Pembentangan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
    
    public function getCategory($idMajlis=0)
    {
        if($idMajlis > 0) {
            $c = new CDbCriteria();
            $c->compare('id_majlis',$idMajlis);
            $c->order = "id";
            $model = $this->findAll($c);
            $i=1;
            foreach ($model as $m) {
                $data['title'][] = $m->tajuk;
                $data['lable'][] = 'F'.$i;
                $i++;
            }
            return $data;
        }
    }
}
