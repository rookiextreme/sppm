<?php

/**
 * This is the model class for table "socdb.majlis".
 *
 * The followings are the available columns in table 'socdb.majlis':
 * @property integer $id
 * @property string $majlis
 * @property string $penganjur
 * @property integer $flag_aktif
 * @property integer $is_bin
 * @property integer $kemaskini_oleh
 * @property string $tkh_kemaskini
 * @property integer $daftar_oleh
 * @property string $tkh_daftar
 *
 * The followings are the available model relations:
 * @property Jadual[] $jaduals
 */
class Majlis extends CActiveRecord
{
    const PERPAGE = 30;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'socdb.majlis';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('majlis', 'required', 'message' => '{attribute} perlu dilengkapkan.'),
			array('flag_aktif, is_bin, kemaskini_oleh, daftar_oleh', 'numerical', 'integerOnly'=>true),
			array('majlis', 'length', 'max'=>255),
			array('penganjur', 'length', 'max'=>12),
			array('tempat', 'length', 'max'=>255),
			array('allowed_peserta_pembentangan', 'length', 'max'=>100),
			array('tkh_kemaskini, tkh_daftar, jenis_soalan, pengesahan_kehadiran, kehadiran_keluarga', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, majlis, penganjur, tempat, flag_aktif, is_bin, kemaskini_oleh, tkh_kemaskini, daftar_oleh, tkh_daftar, jenis_soalan, pengesahan_kehadiran, allowed_peserta_pembentangan', 'safe', 'on'=>'search'),
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
			'jadual' => array(self::HAS_MANY, 'Jadual', 'id_majlis','order'=>'tarikh'),
			'survey' => array(self::HAS_MANY, 'Survey', 'id_majlis'),
			'available_jadual' => array(self::HAS_MANY, 'Jadual', 'id_majlis', 'condition'=>"is_bin=".Utils::NOT_DELETED, 'order'=>'tarikh'),
			'peserta' => array(self::HAS_MANY, 'Peserta', 'id_majlis', 'condition'=>"peserta.is_bin=".Utils::NOT_DELETED),
			'pembentangan' => array(self::HAS_MANY, 'Pembentangan', 'id_majlis', 'condition'=>"is_bin=".Utils::NOT_DELETED),
			'itemPembentangan' => array(self::STAT, 'Pembentangan', 'id_majlis', 'condition'=>"is_bin=".Utils::NOT_DELETED),
			'jenissoalan' => array(self::BELONGS_TO, 'JenisSoalan', array('id'=>'jenis_soalan')),
            'soalan'=>array(self::HAS_MANY,'Soalan',array('id'=>'id_jenis'),'through'=>'jenissoalan'),
//            
//            'survey'=>array(self::HAS_MANY, 'Survey',
//                '',
//                'joinType' => 'INNER JOIN', 
//                'on' => 'survey.id_majlis=peserta.id_peserta',
//                'together'=>true,
//                'condition'=>"is_bin=".Utils::NOT_DELETED
//            ),
		);
	}
    
    public function scopes() {
        return array(
            'active' => array(
                'condition' => 'flag_aktif = :flag_aktif',
                'params' => array(':flag_aktif' => Utils::FLAG_AKTIF)
            ),
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
			'majlis' => 'Majlis',
			'penganjur' => 'Tuan Rumah',
			'tempat' => 'Tempat',
			'flag_aktif' => 'Status',
			'is_bin' => 'Is Bin',
			'kemaskini_oleh' => 'Kemaskini Oleh',
			'tkh_kemaskini' => 'Tarikh Kemaskini',
			'daftar_oleh' => 'Daftar Oleh',
			'tkh_daftar' => 'Tarikh Daftar',
			'flag_survey' => 'Status Survey',
			'jenis_soalan' => 'Jenis Penilaian',
			'pengesahan_kehadiran' => 'Pengesahan Kehadiran',
			'kehadiran_keluarga' => 'Kehadiran Keluarga',
			'allowed_peserta_pembentangan' => 'Peserta Pembentangan',
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
		$criteria->compare('majlis',$this->majlis,true);
		$criteria->compare('penganjur',$this->penganjur,true);
		$criteria->compare('tempat',$this->tempat,true);
		$criteria->compare('flag_aktif',$this->flag_aktif);
		$criteria->compare('is_bin',$this->is_bin);
		$criteria->compare('kemaskini_oleh',$this->kemaskini_oleh);
		$criteria->compare('tkh_kemaskini',$this->tkh_kemaskini,true);
		$criteria->compare('daftar_oleh',$this->daftar_oleh);
		$criteria->compare('tkh_daftar',$this->tkh_daftar,true);
		$criteria->compare('allowed_peserta_pembentangan',$this->allowed_peserta_pembentangan,true);
        $criteria->order = 'id';

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
	 * @return Majlis the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getJadual() {
        if($this->available()->jadual) {
            foreach($this->available()->jadual as $j) {
                if($j->is_bin != Utils::DELETED) {
                    $jadual[] = array(
                        'id' =>$j->id,
                        'tarikh' => Yii::app()->dateFormatter->format("dd MMM yyyy", strtotime($j->tarikh)),
                        'status' => $j->flag_aktif,
                    );
                }
            }
            return $jadual;
        }
    }
    
    public function getSurvey() {
        if($this->available()->survey) {
            foreach($this->available()->with('peserta')->survey as $s) {
//                if($s->is_bin != Utils::DELETED) {
                    $survey[] = array(
                        'id' =>$s->id,
                        'id_pengguna' => $s->id_pengguna,
                        'ulasan' => $s->ulasan,
                    );
                }
//            }
            return $survey;
        }
    }
    
    public function getFieldByID($id,$field=null) {
        if(!is_null($field)&&isset($id))
            return $this->findByPk($id)->$field;
    }
    
    public function checkParticipantExist($pk,$nokp)
    {
        $model = $this->findByPk($pk);
        foreach ($model->peserta as $p) {
            if($nokp == $p->nokp) 
                return false;
        }
        return true;
    }
    
    public function listByWaran()
    {
        $waranStr = '';
        if(!Pengguna::model()->allowAdminAction())
            $waranStr = substr(Yii::app()->user->getState('kod_waran'),0,4);
        
        $this->getDbCriteria()->mergeWith(array(
                'condition' => "penganjur LIKE :penganjur",
                'params' => array(":penganjur" => "$waranStr%"),
            ));
        
        return $this;
    }
    
    public function getMajlisDropdownList()
    {
        if(!Pengguna::model()->allowAdminAction()) {
            return $this->available()->listByWaran()->findAll(array('order' => 'id DESC'));
        } else {
            return $this->available()->findAll(array('order' => 'id DESC'));
        }
    }
}
