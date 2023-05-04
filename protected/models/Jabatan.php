<?php

/**
 * This is the model class for table "examdb.jabatan".
 *
 * The followings are the available columns in table 'examdb.jabatan':
 * @property integer $kod
 * @property string $keterangankod
 * @property integer $ministry_code
 *
 * The followings are the available model relations:
 * @property Kementerian $ministryCode
 */
class Jabatan extends CActiveRecord 
{
    const DDSA_KKR = '105';
    const DDSA_JKR = '105101';
    const LAIN_LAIN = 999;
    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'socdb.jabatan';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('kod', 'required'),
            array('kod, ministry_code', 'numerical', 'integerOnly' => true),
            array('keterangankod', 'length', 'max' => 70),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('kod, keterangankod, ministry_code', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'kod' => 'Kod',
            'keterangankod' => 'Keterangankod',
            'ministry_code' => 'Ministry Code',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('kod', $this->kod);
        $criteria->compare('keterangankod', $this->keterangankod, true);
        $criteria->compare('ministry_code', $this->ministry_code);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Jabatan the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    /** 
     * Get list of data
     * @return string array
     */
    public function getList(){
        $model = $this->findAll();
        foreach($model as $item){
            $list[$item->kod] = $item->kod . ' - ' . $item->keterangankod;
        }
        return $list;
    }
    
    public function getAgenciesList()
    {
        $c = new CDbCriteria();
        $c->condition = 'ministry_code = :ddsa_kkr AND kod <> :ddsa_jkr';
        $c->params = array(':ddsa_kkr'=>self::DDSA_KKR,':ddsa_jkr'=>self::DDSA_JKR,);
        return $this->findAll($c);
    }

}
