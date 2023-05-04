<?php

/**
 * This is the model class for table "socdb.jadual".
 *
 * The followings are the available columns in table 'socdb.jadual':
 * @property integer $id
 * @property integer $daftar_oleh
 * @property string $tkh_daftar
 * @property integer $kemaskini_oleh
 * @property string $tkh_kemaskini
 * @property integer $flag_aktif
 * @property integer $is_bin
 * @property integer $id_majlis
 *
 * The followings are the available model relations:
 * @property Pembentangan[] $pembentangans
 * @property Majlis $idMajlis
 * @property Permohonan[] $permohonans
 */
class Jadual extends CActiveRecord
{
    public $tkh_mula;
    public $tkh_tamat;

    const PERPAGE = 30;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'socdb.jadual';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_majlis', 'required', 'message' => '{attribute} perlu dilengkapkan.'),
			array('tarikh, tkh_mula, tkh_tamat', 'required', 'message' => '{attribute} perlu dilengkapkan.'),
			array('tarikh', 'unique', 'message' => '{attribute} telah didaftarkan.'),
			array('daftar_oleh, kemaskini_oleh, flag_aktif, is_bin, id_majlis', 'numerical', 'integerOnly'=>true),
			array('tarikh, tkh_mula, tkh_tamat, tkh_daftar, tkh_kemaskini', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tarikh, tkh_mula, tkh_tamat, id_majlis, daftar_oleh, tkh_daftar, kemaskini_oleh, tkh_kemaskini, flag_aktif, is_bin, id_majlis', 'safe', 'on'=>'search'),
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
			'pembentangans' => array(self::HAS_MANY, 'Pembentangan', 'id_jadual'),
			'majlis' => array(self::BELONGS_TO, 'Majlis', 'id_majlis'),
			'r_kehadiran' => array(self::HAS_MANY, 'Kehadiran', 'id_jadual'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tarikh' => 'Tarikh',
			'tkh_mula' => 'Tarikh Mula',
			'tkh_tamat' => 'Tarikh Tamat',
			'daftar_oleh' => 'Daftar Oleh',
			'tkh_daftar' => 'Tarikh Daftar',
			'kemaskini_oleh' => 'Kemaskini Oleh',
			'tkh_kemaskini' => 'Tarikh Kemaskini',
			'flag_aktif' => 'Status',
			'is_bin' => 'Is Bin',
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
		$criteria->compare('tarikh',$this->tkh_mula,true);
		$criteria->compare('daftar_oleh',$this->daftar_oleh);
		$criteria->compare('tkh_daftar',$this->tkh_daftar,true);
		$criteria->compare('kemaskini_oleh',$this->kemaskini_oleh);
		$criteria->compare('tkh_kemaskini',$this->tkh_kemaskini,true);
		$criteria->compare('flag_aktif',$this->flag_aktif);
		$criteria->compare('is_bin',$this->is_bin);
		$criteria->compare('id_majlis',$this->id_majlis);

		return new CActiveDataProvider($this, array(
            'pagination'=>array(
                    'pageSize'=> self::PERPAGE,
            ),
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Jadual the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function beforeSave() 
    {
        if (parent::beforeSave()) {
            if (!isset($this->tkh_daftar)){
                $this->tkh_daftar = Yii::app()->Date->now();
                $this->daftar_oleh = Yii::app()->user->getState('nama');

            } else if (isset($this->tkh_daftar)) {
                $this->tkh_kemaskini = Yii::app()->Date->now();
                $this->tarikh = Yii::app()->dateFormatter->format("yyyy-MM-dd HH:mm:ss", strtotime($this->tarikh));
                $this->kemaskini_oleh = Yii::app()->user->getState('nama');

            }
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Takes two dates formatted as YYYY-MM-DD and creates an inclusive array of the dates between the from and to dates.
     * @param type $strDateFrom
     * @param type $strDateTo
     * @return array
     */
    function createDateRangeArray($strDateFrom,$strDateTo) 
    {
        $aryRange=array();

        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2), substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2), substr($strDateTo,8,2),substr($strDateTo,0,4));

        if ($iDateTo>=$iDateFrom) {
            array_push($aryRange,date('Y-m-d',$iDateFrom)); // first entry

            while ($iDateFrom<$iDateTo) {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('Y-m-d',$iDateFrom));
            }
        }
        return $aryRange;
    }
    
    public function getFieldByID($id,$field=null) {
        if(!is_null($field)&&isset($id))
            return $this->findByPk($id)->$field;
    }
    
    /**
     * Returns the status for record existence that come from Majlis's model relationship "jadual"
     * @param type $jadualList
     * @param type $startDate
     * @param type $endDate
     * @return boolean
     */
    public function checkJadualExist($jadualList,$startDate,$endDate)
    {
        if($jadualList) {
            foreach($jadualList as $j) {
                $tarikh = Yii::app()->dateFormatter->format("dd-MM-yyyy", strtotime($j->tarikh));
                if($tarikh == $startDate || $tarikh == $endDate)
                    return true;
            }
        }
        return false;
    }
}
