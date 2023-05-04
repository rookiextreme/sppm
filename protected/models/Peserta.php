<?php

/**
 * This is the model class for table "socdb.peserta".
 *
 * The followings are the available columns in table 'socdb.peserta':
 * @property integer $id_pengguna
 * @property string $nama
 * @property string $nokp
 * @property string $organisasi
 * @property string $kod_waran
 * @property string $tel_pej
 * @property string $email
 * @property integer $kod_jabatan
 * @property string $peranan
 *
 * The followings are the available model relations:
 * @property Permohonan[] $permohonans
 * @property Survey[] $surveys
 */
class Peserta extends CActiveRecord
{
    var $tkh_daftar;

    const PERPAGE = 30;

    const KATEGORI_BENGKEL = 1;
    const KATEGORI_KERTASKERJA = 2;
    const KATEGORI_TETAMU = 3;
    const KATEGORI_KONVENSYEN = 4;
    const KATEGORI_MESYUARAT = 5;

    const STATUS_TIDAK_HADIR = 0;
    const STATUS_AKAN_HADIR = 1;
    const STATUS_TIDAK_HADIR_BEPENGGANTI = 2;

    const BELUM_SURVEY = 0;
    const SUDAH_SURVEY = 1;

    const BUKAN_KAKITANGAN_JKR = 0;
    const KAKITANGAN_JKR = 1;


    public static $jantinaArr = array("L" => "Lelaki", "P" => "Perempuan");
    public static $kakitanganArr = array("1" => "Kakitangan", "0" => "Bukan Kakitangan");
    public static $kategoriArr = array("1" => "Peserta Bengkel", "2" => "Peserta Kertas Kerja", "3" => "Tetamu");
    public static $hubunganArr = array("1" => "Isteri", "2" => "Anak");
    public static $dropdownKategori = array(
                    self::KATEGORI_KONVENSYEN => 'Konvensyen',
                    self::KATEGORI_MESYUARAT => 'Mesyuarat',
                    self::KATEGORI_KERTASKERJA => 'K.Kerja',
                    self::KATEGORI_BENGKEL => 'Bengkel',
                    self::KATEGORI_TETAMU => 'Tetamu',
                );
    public static $dropdownKehadiran = array(
                    self::STATUS_AKAN_HADIR => 'Akan Hadir',
                    self::STATUS_TIDAK_HADIR => 'Tidak Hadir',
                    self::STATUS_TIDAK_HADIR_BEPENGGANTI => 'Tidak Hadir Berpengganti',
                );

   public static $kategori_peserta = array(
                    self::KATEGORI_BENGKEL => 'Peserta Bengkel',
                    self::KATEGORI_KERTASKERJA => 'Peserta Kertas Kerja',
                    self::KATEGORI_TETAMU => 'Tetamu',
                    self::KATEGORI_KONVENSYEN => 'Peserta Konvensyen',
                    self::KATEGORI_MESYUARAT => 'Peserta Mesyuarat',
                );
    var $status_kehadiran = array(
                    self::STATUS_AKAN_HADIR => 'Akan Hadir',
                    self::STATUS_TIDAK_HADIR => 'Tidak Hadir',
                    self::STATUS_TIDAK_HADIR_BEPENGGANTI => 'Tidak Hadir Berpengganti',
                );

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'socdb.peserta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(

			array('nokp, nama, organisasi, email, kategori', 'required', 'message' => '{attribute} mesti dilengkapkan.'),
			array('nokp, nama, organisasi, email, nama_pengganti, email_pengganti, tel_pengganti', 'required', 'message' => '{attribute} mesti dilengkapkan.', 'on' => 'pengganti'),
			array('id_majlis, status_survey, status, kakitangan, kod_jabatan, berpengganti, kategori, bilik_tambahan, pengangkutan_airport', 'numerical', 'integerOnly'=>true),
			array('nama', 'length', 'max'=>255),
			array('gred', 'length', 'max'=>5),
			array('jantina', 'length', 'max'=>1),
			array('nokp, kod_waran', 'length', 'min'=>12,'max'=>12,
                    'tooShort'=>Yii::t("translation", "{attribute} tidak boleh kurang dari 12 digit."),
                    'tooLong'=>Yii::t("translation", "{attribute} tidak boleh lebih dari 12 digit.")),
			array('tel_pej', 'length', 'max'=>15),
			array('email, email_pengganti', 'length', 'max'=>100),
			array('email, email_pengganti', 'email', 'message' => 'Gunakan format {attribute} yang betul.'),
			array('organisasi, nama_pengganti, email_pengganti, tel_pengganti,id_lawatan, kerusi', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_pengguna, nama, nokp, kakitangan, organisasi, kod_waran, tel_pej, email, kod_jabatan, id_majlis, gred, jantina, no_tel, status_survey, berpengganti, nama_pengganti, email_pengganti, tel_pengganti, kategori, no_tel, bilik_tambahan, pengangkutan_airport, masa_ketibaan, masa_berlepas,tkh_checkin,tkh_checkout', 'safe', 'on'=>'search'),
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
			'surveys' => array(self::HAS_MANY, 'Survey', 'id_pengguna'),
            'pegawai' => array(self::BELONGS_TO, 'ListPegawai', array('nokp' => 'nokp')),
			'majlis' => array(self::BELONGS_TO, 'Majlis', 'id_majlis'),
			'r_kehadiran' => array(self::HAS_MANY, 'Kehadiran', 'id_pengguna'),
            'jadual' => array(self::HAS_MANY,'Jadual',array('id'=>'id_majlis'),'through'=>'majlis'),
			'lawatan' => array(self::BELONGS_TO, 'Lawatan', 'id_lawatan'),
		);
	}

    public function scopes() {
        return array(
            'available' => array(
                'condition' => 't.is_bin = :is_bin OR t.is_bin IS NULL',
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
			'id_pengguna' => 'ID',
			'nama' => 'Nama',
			'nokp' => 'No KP',
			'organisasi' => 'Organisasi',
			'kod_waran' => 'Kod Waran',
			'tel_pej' => 'Tel Pejabat',
			'email' => 'Email',
			'no_tel' => 'No. Telefon Bimbit',
			'kod_jabatan' => 'Jabatan',
			'id_majlis' => 'ID Majlis',
			'gred' => 'Gred',
			'jantina' => 'Jantina',
			'status_survey' => 'Status Survey',
			'kakitangan' => 'Kakitangan JKR',
			'berpengganti' => 'Berpengganti',
			'status' => 'Status Kehadiran',
			'nama_pengganti' => 'Nama Pengganti',
			'email_pengganti' => 'Email Pengganti',
			'tel_pengganti' => 'No. Tel Pengganti',
			'no_tel' => 'No. Telefon',
			'tkh_checkin' => 'Tarikh Check In',
			'tkh_checkout' => 'Tarikh Check Out',
			'bilik_tambahan' => 'Bilik Tambahan',
			'pengangkutan_airport' => 'Pengangkutan ke Airport',
			'masa_ketibaan' => 'Masa Ketibaan',
			'masa_berlepas' => 'Masa Berlepas',
            'kerusi' => 'Kerusi'

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

		$criteria->compare('id_pengguna',$this->id_pengguna);
		$criteria->compare('LOWER(nama)',strtolower($this->nama),true);
		$criteria->compare('nokp',$this->nokp,true);
		$criteria->compare('LOWER(organisasi)',strtolower($this->organisasi),true);
		$criteria->compare('kod_waran',$this->kod_waran,true);
		$criteria->compare('tel_pej',$this->tel_pej,true);
		$criteria->compare('LOWER(email)',strtolower($this->email),true);
		$criteria->compare('kod_jabatan',$this->kod_jabatan);
		$criteria->compare('id_majlis',$this->id_majlis);
		$criteria->compare('gred',$this->gred);
		$criteria->compare('jantina',$this->jantina);
		$criteria->compare('status_survey',$this->status_survey);
		$criteria->compare('kakitangan',$this->kakitangan);
		$criteria->compare('kategori',$this->kategori);
		$criteria->compare('berpengganti',$this->berpengganti);
		$criteria->compare('status',$this->status);
		$criteria->compare('nama_pengganti',$this->nama_pengganti);
		$criteria->compare('email_pengganti',$this->email_pengganti);
		$criteria->compare('tel_pengganti',$this->tel_pengganti);
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
	 * @return Peserta the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getPeserta($id)
    {
        $this->getDbCriteria()->mergeWith(array(
                'condition' => "id_majlis = :id_majlis",
                'params' => array(':id_majlis' => $id),
            ));

        return $this;
    }

	public function getKehadiran($id)
    {
        $this->getDbCriteria()->mergeWith(array(
                'condition' => "status = 1 AND id_penginapan IS NULL",
            ));

        return $this;
    }

    public function getKehadiranArr($id,$searchStr=null)
    {
        $c = new CDbCriteria();
        $c->compare('id_majlis', $id);
        $c->compare('is_bin', Utils::NOT_DELETED);
        $c->order = "nama";

        if(!is_null($searchStr)) {
            $c2 = new CDbCriteria();
            foreach ($searchStr as $txt) {
                $c2->compare('LOWER(nama)', strtolower($txt), true, 'OR');
                $c2->compare('LOWER(nokp)', strtolower($txt), true, 'OR');
            }
            $c->mergeWith($c2, 'AND');
        }

        $peserta = $this->findAll($c);
        $data = array();
        foreach ($peserta as $p) {
			$data['lawatan'][$p->id_lawatan] += 1;
            if($p->r_kehadiran) {
                foreach ($p->r_kehadiran as $k) {
                    $data[$k->id_pengguna]['id_pengguna'] = $p->id_pengguna;
                    $data[$k->id_pengguna]['id_majlis'] = $id;
                    $data[$k->id_pengguna]['nama'] = $p->nama;
                    $data[$k->id_pengguna]['nokp'] = $p->nokp;
                    $data[$k->id_pengguna]['kategori'] = $p->kategori;
                    $data[$k->id_pengguna]['berpengganti'] = $p->berpengganti;
                    $data[$k->id_pengguna]['organisasi'] = $p->organisasi;
                    $data[$k->id_pengguna][$k->id_jadual]['id_kehadiran'] = $k->id_kehadiran;
                    $data[$k->id_pengguna][$k->id_jadual]['kehadiran'] = $k->kehadiran;
                    $data[$k->id_pengguna][$k->id_jadual]['tarikh'] = Yii::app()->dateFormatter->format("dd-MM-yyyy", strtotime($k->jadual->tarikh));
                    $data[$k->id_pengguna]['id_lawatan'] = $p->id_lawatan;
                    $data[$k->id_pengguna]['tempat'] = $p->lawatan->tempat;

                }
            }
        }
        return $data;
    }

    public function getCategoryImg($category)
    {
        echo "<img src=".Yii::app()->request->baseUrl.'/images/peserta_'.$category.'.png'.">";
    }

    public function dropdownListCategory()
    {
        return array(
                    self::KATEGORI_KERTASKERJA => 'K.Kerja',
                    self::KATEGORI_BENGKEL => 'Bengkel',
                    self::KATEGORI_TETAMU => 'Tetamu',
                );
    }

    public function getKategoriPeserta($idMajlis)
    {
        $model = Majlis::model()->findByPk($idMajlis);
        if($model->kategori_peserta) {
            $arr = explode(",", $model->kategori_peserta);
            foreach ($arr as $a) {
                $data[$a] = Peserta::$kategori_peserta[$a];
            }
            return $data;
        }
    }

    public function getAllowedPeserta($string=NULL)
    {
        if($string) {
            $i=0;
            $data = "";
            $exp = explode(",", $string);
            $numItems = count($exp);
            foreach ($exp as $e) {
                $data .= $this->kategori_peserta[$e];
                if (++$i < $numItems)
                    $data .= ', ';
            }
            return $data;
        }
    }
}
