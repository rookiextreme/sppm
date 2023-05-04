<?php

/**
 * This is the model class for table "socdb.pengguna".
 *
 * The followings are the available columns in table 'socdb.pengguna':
 * @property integer $id
 * @property string $nama
 * @property string $nokp
 * @property string $organisasi
 * @property string $kod_waran
 * @property string $tel_pej
 * @property string $email
 * @property string $peranan
 *
 * The followings are the available model relations:
 * @property Permohonan[] $permohonans
 * @property Survey[] $surveys
 */
class Pengguna extends CActiveRecord
{
    var $tkh_daftar;
    
    const PERPAGE = 30;
    
    const ROLE_SEKRETARIAT = 3;
    const ROLE_PENGANJUR = 2;
    const ROLE_KHAS = 1;
    const ROLE_PENGGUNA = 0;
    
    var $role = array(
                    self::ROLE_PENGGUNA => 'pengguna',
                    self::ROLE_KHAS => 'khas',
                    self::ROLE_PENGANJUR => 'Tuan rumah',
                    self::ROLE_SEKRETARIAT => 'Sekretariat',
                );
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'socdb.pengguna';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nokp, nama, organisasi, email', 'required', 'message' => '{attribute} pelu dilengkapkan.'),
			array('nokp', 'unique'),
			array('id_majlis', 'numerical', 'integerOnly'=>true),
			array('nama', 'length', 'max'=>255),
			array('nokp, kod_waran', 'length', 'max'=>12),
			array('tel_pej', 'length', 'max'=>15),
			array('email', 'length', 'max'=>100),
			array('email', 'email'),
			array('peranan', 'length', 'max'=>25),
			array('organisasi', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, nama, nokp, organisasi, kod_waran, tel_pej, email, peranan, id_majlis', 'safe', 'on'=>'search'),
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
            'pegawai' => array(self::BELONGS_TO, 'ListPegawai', array('nokp' => 'nokp')),
		);
	}

    public function scopes() {
        return array(
            'available' => array(
                'condition' => 'is_bin <> :is_bin OR is_bin IS NULL',
                'params' => array(':is_bin' => Utils::NOT_DELETED)
            ),
            'ownlist' => array(
                'condition' => 'kod_waran LIKE :kod_waran',
                'params' => array(":kod_waran" => substr(Yii::app()->user->getState('kod_waran'),0,4)."%")
            ),
            'nonadmin' => array(
                'condition' => 'peranan <> :peranan',
                'params' => array(':peranan' => Pengguna::ROLE_SEKRETARIAT)
            ),
            'organizeronly' => array(
                'condition' => 'peranan = :peranan',
                'params' => array(':peranan' => Pengguna::ROLE_PENGANJUR)
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
			'nama' => 'Nama',
			'nokp' => 'No KP',
			'organisasi' => 'Organisasi',
			'kod_waran' => 'Kod Waran',
			'tel_pej' => 'Tel Pejabat',
			'email' => 'Email',
			'peranan' => 'Peranan',
			'id_majlis' => 'ID Majlis',
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
		$criteria->compare('nama',$this->nama,true);
		$criteria->compare('nokp',$this->nokp,true);
		$criteria->compare('organisasi',$this->organisasi,true);
		$criteria->compare('kod_waran',$this->kod_waran,true);
		$criteria->compare('tel_pej',$this->tel_pej,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('peranan',$this->peranan);
		$criteria->compare('id_majlis',$this->id_majlis);
		$criteria->compare('gred',$this->gred);
        $criteria->order = "nama";

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
	 * @return Pengguna the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getRole() {
        if($this->peranan){
            return array($this->role[$this->peranan]);
        }
        return array();
    }
    
    public function allowAdminAction()
    {
        $profile = $this->findByPk(Yii::app()->user->id);
        if($profile && $profile->peranan == self::ROLE_SEKRETARIAT)
            return true;
        return false;
            
    }
}
