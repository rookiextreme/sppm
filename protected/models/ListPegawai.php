<?php

/**
 * This is the model class for table "list_pegawai".
 *
 * The followings are the available columns in table 'list_pegawai':
 * @property string $nokp
 * @property string $nama
 * @property string $kod_gred
 * @property string $jawatan
 * @property string $gelaran_jawatan
 * @property string $email
 * @property string $tel_bimbit
 * @property string $fax_pejabat
 * @property string $katalaluan
 * @property string $kod_waran
 * @property string $kod_jurusan
 * @property string $kod_skim
 * @property string $caw
 * @property string $bah
 * @property string $alamat_pejabat
 * @property string $tel_pejabat
 * @property string $gelaran
 */
class ListPegawai extends CActiveRecord
{
//    var $jantina;
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'socdb.list_pegawai';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nokp, kod_waran', 'length', 'max'=>12),
			array('jantina', 'length', 'max'=>1),
			array('jawatan, kod_gelaran_jawatan', 'length', 'max'=>255),
			array('kod_gred, kod_jurusan, kod_skim', 'length', 'max'=>50),
			array('email', 'length', 'max'=>200),
			array('tel_bimbit, tel_pejabat', 'length', 'max'=>15),
			array('nama, jantina', 'safe'),
			array('nama', 'length', 'min'=>3, 'max'=>255, 
                    'tooShort'=>Yii::t("translation", "{attribute} is too short."),
                    'tooLong'=>Yii::t("translation", "{attribute} is too long.")),
			array('nama', 'required','message' => '{attribute} perlu dilengkapkan'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('organisasi, nokp, nama, kod_gred, jawatan, kod_gelaran_jawatan, email, tel_bimbit, katalaluan, kod_waran, kod_jurusan, kod_skim, tel_pejabat, jantina', 'safe', 'on'=>'search'),
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
            'waran' => array(self::HAS_MANY, 'LWaranPej', array('kod_waran_pej' => 'kod_waran')),
            '_user' => array(self::BELONGS_TO, 'Pengguna', array('nokp' => 'nokp'), 'order' => 'nokp ASC'),
            'peserta' => array(self::BELONGS_TO, 'Peserta', array('nokp' => 'nokp'), 'order' => 'nokp ASC'),
		);
	}
    
    public function scopes() {
        return array(
            'notinpengguna' => array(
                'condition'=>'nokp NOT IN( SELECT nokp FROM socdb.pengguna)',
            ),
            'ownlist' => array(
                'condition' => 'kod_waran LIKE :kod_waran',
                'params' => array(":kod_waran" => substr(Yii::app()->user->getState('kod_waran'),0,4)."%")
            ),
        );
    }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'nokp' => 'Nokp',
			'nama' => 'Nama',
			'kod_gred' => 'Gred',
			'jawatan' => 'Jawatan',
			'kod_gelaran_jawatan' => 'Gelaran Jawatan',
			'email' => 'Email',
			'tel_bimbit' => 'Tel Bimbit',
			'katalaluan' => 'Katalaluan',
			'kod_waran' => 'Organisasi',
			'kod_jurusan' => 'Kod Jurusan',
			'kod_skim' => 'Kod Skim',
			'tel_pejabat' => 'Tel Pejabat',
			'jantina' => 'Jantina',
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

		$criteria->compare('nokp',$this->nokp,true);
		$criteria->compare('LOWER(nama)',strtolower($this->nama),true);
		$criteria->compare('kod_gred',$this->kod_gred,true);
		$criteria->compare('jawatan',$this->jawatan,true);
		$criteria->compare('kod_gelaran_jawatan',$this->kod_gelaran_jawatan,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('tel_bimbit',$this->tel_bimbit,true);
		$criteria->compare('katalaluan',$this->katalaluan,true);
		$criteria->compare('kod_waran',$this->kod_waran,true);
		$criteria->compare('kod_jurusan',$this->kod_jurusan,true);
		$criteria->compare('kod_skim',$this->kod_skim,true);
		$criteria->compare('tel_pejabat',$this->tel_pejabat,true);
		$criteria->compare('jantina',$this->jantina);
        $criteria->order = "nama";

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ListPegawai the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function getName($nokp)
    {
        $c = new CDbCriteria();
        $c->condition = "nokp = :nokp";
        $c->params = array(":nokp" => $nokp);
        
        return $this->find($c);
    }
    
    public function getSearch($searchStr)
    {
        $searchStr = str_replace(" ", "%", $searchStr);
        $this->getDbCriteria()->mergeWith(array(
                'condition' => "nama ILIKE :nama OR nokp LIKE :nokp",
                'params' => array(":nokp" => "%$searchStr%", ":nama" => "%$searchStr%"),
            ));
        
        return $this;
    }
}
