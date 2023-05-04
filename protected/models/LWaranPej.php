<?php

/**
 * This is the model class for table "l_waran_pej".
 *
 * The followings are the available columns in table 'l_waran_pej':
 * @property string $kod_waran_pej
 * @property string $waran_pej
 * @property string $blok
 * @property string $baris1
 * @property string $baris2
 * @property string $baris3
 * @property string $telefon
 * @property string $fax
 * @property string $tkh_masuk
 * @property string $masuk_oleh
 * @property string $tkh_kemaskini
 * @property string $kemaskini_oleh
 * @property integer $flag
 * @property string $kod_skala
 * @property integer $kod_bentuk_penempatan
 * @property string $ketua_jabatan
 * @property string $namaringkas
 */
class LWaranPej extends CActiveRecord
{
    // Kategori berdasarkan bilangan '0' from format 12 digit
    const SEKTOR = '0000000000'; // 10 zero
    const CAWANGAN = '00000000'; // 8 zero
    const BAHAGIAN = '000000';   // 6 zero
    const UNIT = '0000';         // 4 zero
    const SEKSYEN = '00';        // 2 zero
    
    // Kategori kod waran berdasarkan 2 nombor pertama
    const NEGERI = '08';
    const KEMENTERIAN = '07'; // Penempatan bagi kakitangan kader
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'socdb.l_waran_pej';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('kod_waran_pej', 'required'),
			array('flag, kod_bentuk_penempatan', 'numerical', 'integerOnly'=>true),
			array('kod_waran_pej, telefon, fax, namaringkas', 'length', 'max'=>15),
			array('waran_pej', 'length', 'max'=>200),
			array('blok, ketua_jabatan', 'length', 'max'=>50),
			array('baris1, baris2, baris3', 'length', 'max'=>100),
			array('masuk_oleh, kemaskini_oleh, kod_skala', 'length', 'max'=>12),
			array('tkh_masuk, tkh_kemaskini', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('kod_waran_pej, waran_pej, blok, baris1, baris2, baris3, telefon, fax, tkh_masuk, masuk_oleh, tkh_kemaskini, kemaskini_oleh, flag, kod_skala, kod_bentuk_penempatan, ketua_jabatan, namaringkas', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'kod_waran_pej' => 'Organisasi',
			'waran_pej' => 'Waran Pej',
			'blok' => 'Blok',
			'baris1' => 'Baris1',
			'baris2' => 'Baris2',
			'baris3' => 'Baris3',
			'telefon' => 'Telefon',
			'fax' => 'Fax',
			'tkh_masuk' => 'Tkh Masuk',
			'masuk_oleh' => 'Masuk Oleh',
			'tkh_kemaskini' => 'Tkh Kemaskini',
			'kemaskini_oleh' => 'Kemaskini Oleh',
			'flag' => 'Flag',
			'kod_skala' => 'Kod Skala',
			'kod_bentuk_penempatan' => 'Kod Bentuk Penempatan',
			'ketua_jabatan' => 'Ketua Jabatan',
			'namaringkas' => 'Namaringkas',
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

		$criteria->compare('kod_waran_pej',$this->kod_waran_pej,true);
		$criteria->compare('waran_pej',$this->waran_pej,true);
		$criteria->compare('blok',$this->blok,true);
		$criteria->compare('baris1',$this->baris1,true);
		$criteria->compare('baris2',$this->baris2,true);
		$criteria->compare('baris3',$this->baris3,true);
		$criteria->compare('telefon',$this->telefon,true);
		$criteria->compare('fax',$this->fax,true);
		$criteria->compare('tkh_masuk',$this->tkh_masuk,true);
		$criteria->compare('masuk_oleh',$this->masuk_oleh,true);
		$criteria->compare('tkh_kemaskini',$this->tkh_kemaskini,true);
		$criteria->compare('kemaskini_oleh',$this->kemaskini_oleh,true);
		$criteria->compare('flag',$this->flag);
		$criteria->compare('kod_skala',$this->kod_skala,true);
		$criteria->compare('kod_bentuk_penempatan',$this->kod_bentuk_penempatan);
		$criteria->compare('ketua_jabatan',$this->ketua_jabatan,true);
		$criteria->compare('namaringkas',$this->namaringkas,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return LWaranPej the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
     * This method will return full organization name based on code given.
     * 
     * @param string $kod_waran
     * @return string
     */
    function getFullWaranName($kod_waran) {
        $waran='';
        if(substr($kod_waran,-8)==self::CAWANGAN) {
            $waran.=$this->returnWaran($kod_waran, false);
        } else if(substr($kod_waran,-6)==self::BAHAGIAN) {
            $waran.=$this->returnWaran($kod_waran, false);
            $waran.=$this->returnWaran(substr($kod_waran,0,4).self::CAWANGAN, true);
        } else if(substr($kod_waran,-4)==self::UNIT) {
            $waran.=$this->returnWaran($kod_waran, false);
            $waran.=$this->returnWaran(substr($kod_waran,0,6).self::BAHAGIAN, true);
            $waran.=$this->returnWaran(substr($kod_waran,0,4).self::CAWANGAN, true);
        } else if(substr($kod_waran,-2)==self::SEKSYEN) {
            $waran.=$this->returnWaran($kod_waran, false);
            $waran.=$this->returnWaran(substr($kod_waran,0,8).self::UNIT, true);
            $waran.=$this->returnWaran(substr($kod_waran,0,4).self::CAWANGAN, true);
            $waran.=$this->returnWaran(substr($kod_waran,0,4).self::CAWANGAN, true);
        } 

        if(substr($kod_waran,-10)!=self::CAWANGAN) {
            if(substr($kod_waran,0,2)!=self::NEGERI)
            $waran.=$this->returnWaran(substr($kod_waran,0,2).self::SEKTOR, true);
        } 

        if(substr($kod_waran,0,2)==self::KEMENTERIAN) {
            $waran.=', (Kader)';
        }
        return $waran;	
    }
    
    private function returnWaran($kod_waran,$comma)
    {
        if($model = $this->findByAttributes(array('kod_waran_pej'=>$kod_waran))) {
            $c = $comma?', ':'';
            return $c.$model->waran_pej;
        }
        return null;
    }

    public function getWaranName($kod_waran)
    {
        return $this->findByAttributes(array('kod_waran_pej'=>$kod_waran))->waran_pej;
    }
}
