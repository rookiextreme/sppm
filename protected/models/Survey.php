<?php

/**
 * This is the model class for table "socdb.survey".
 *
 * The followings are the available columns in table 'socdb.survey':
 * @property integer $id
 * @property string $tkh_survey
 * @property integer $id_pengguna
 * The followings are the available model relations:
 * @property Permohonan $idPermohonan
 * @property Pengguna $idPengguna
 */
class Survey extends CActiveRecord
{
    const FLAG_AKTIF = 1;
    const FLAG_TAK_AKTIF = 0;
    
    var $skala = array(
        1 => 'Lemah',
        2 => 'Kurang Memuaskan',
        3 => 'Memuaskan',
        4 => 'Baik',
        5 => 'Cemerlang',
    );
     
//     var $fields = array(
//        'soalan1' => 'soalan1',
//        'soalan2' => 'soalan2',
//        'soalan3' => 'soalan3',
//        'soalan4' => 'soalan4',
//        'soalan5' => 'soalan5',
//        'soalan6' => 'soalan6',
//        'soalan7' => 'soalan7',
//        'soalan8' => 'soalan8',
//        'soalan9' => 'soalan9',
//        'soalan10' => 'soalan10',
//        'pembentangan' => 'soalan11',
//        'ulasan' => 'ulasan',
//        'cadangan' => 'cadangan',
//    );
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'socdb.survey';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('id_pengguna, id_majlis, soalan1, soalan2, soalan3, soalan4, soalan5, soalan6, soalan7, soalan8, soalan9, soalan10', 'numerical', 'integerOnly'=>true),
			array('tkh_survey, markah, pembentangan, pilihan, cadangan, ulasan','safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, tkh_survey, id_pengguna, id_majlis, soalan1, soalan2, soalan3, soalan4, soalan5, soalan6, soalan7, soalan8, soalan9, soalan10, pembentangan, markah, pilihan', 'safe', 'on'=>'search'),
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
			'peserta' => array(self::BELONGS_TO, 'Peserta', 'id_pengguna'),
//            'r_pembentangan' => array(self::HAS_MANY,'Pembentangan',array('id'=>'id_majlis'),'through'=>'majlis'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tkh_survey' => 'Tkh Survey',
			'id_pengguna' => 'Id Pengguna',
			'id_majlis' => 'Id Majlis',
			'soalan1' => 'Soalan 1',
            'soalan2' => 'Soalan 2',
            'soalan3' => 'Soalan 3',
            'soalan4' => 'Soalan 4',
            'soalan5' => 'Soalan 5',
            'soalan6' => 'Soalan 6',
            'soalan7' => 'Soalan 7',
            'soalan8' => 'Soalan 8',
            'soalan9' => 'Soalan 9',
            'soalan10' => 'Soalan 10',
            'pilihan' => 'Pilihan',
            'pembentangan' => 'Soalan 11',
            'cadangan' => 'H. CADANGAN',
            'ulasan' => 'G. ULASAN',
		);
	}
          
    public function beforeSave()
	{
        if(parent::beforeSave())
        {
            $this->tkh_survey = date('Y-m-d');
            return TRUE;
        }
        return FALSE;
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
		$criteria->compare('tkh_survey',$this->tkh_survey,true);
		$criteria->compare('id_pengguna',$this->id_pengguna);
		$criteria->compare('id_majlis',$this->id_majlis);
		$criteria->compare('markah',$this->markah,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
//    public function getRecord()
//    {
//        foreach ($this->fields as $fieldName => $fieldDisplay) {
//            foreach ($this->skala as $value => $label) {
//                $criteria = new CDbCriteria();
//                $criteria->condition = "$fieldName = $value";
//                $data[$fieldName][$value] = $this->count($criteria);
//                $data[$fieldName]['jumlah'] += $data[$fieldName][$value];
//            }
//            $data['jumlah'] += $data[$fieldName]['jumlah'];
//        }
//        return $data;
//    }
	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Survey the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public static function getSurveyStartStopLink($flagSurvey,$idMajlis)
    {
        if($flagSurvey == Utils::FLAG_AKTIF)
            return "<a href='".Yii::app()->createUrl("majlis/stop", array("id"=>$idMajlis))."' title='Hentikan penilaian' onclick='return confirm(\"Proses penilaian akan dihentikan seterusnya akan menyekat peserta daripada menjalankan penilaian. Adakah anda pasti?\")'><img src='images/stop.png' /></a>";
        else
            return "<a href='".Yii::app()->createUrl("majlis/start", array("id"=>$idMajlis))."' title='Mulakan penilaian' onclick='return confirm(\"Proses ini akan membolehkan peserta menjalankan penilaian melalui email yang dihantar kepada semua peserta yang hadir. Adakah anda pasti?\")'><img src='images/play.png' /></a>";
    }
    
    public function getAttendanceList($idMajlis) 
    {
        $majlis = Majlis::model()->findByPk($idMajlis);
        $data = array();
        foreach ($majlis->peserta as $p) {
            $kehadiran = false;
            foreach ($p->r_kehadiran as $k) {
                if($k->kehadiran == Kehadiran::STATUS_HADIR) {
                    $kehadiran = true;
                }
            }
            if($kehadiran && $p->berpengganti == 0) {
                if($p->status_survey == self::FLAG_AKTIF && $p->kategori != Peserta::KATEGORI_TETAMU)
                    $data['selesai'] += 1;
                else if($p->kategori != Peserta::KATEGORI_TETAMU)
                    $data['belum'] += 1;
                $data['hadir'] += 1;
            } else {
                $data['takhadir'] += 1;
            }
        }
        return $data;
    }

    public function getAverageStatistic($idMajlis=0)
    {
        $data = array();
        $list = array(
                    'soalan1' => 'Pencapaian Objektif (Bahagian B1)',
                    'soalan7' => 'Hasil Rumusan Bengkel (Bahagian D)',
                    'soalan8' => 'Urusetia dan Penyelarasan Mesyuarat (Bahagian E1)',
                );
        
        $criteria = new CDbCriteria();
        $criteria->with = 'majlis';
        $criteria->addCondition('(majlis.is_bin = '. Utils::NOT_DELETED.' OR majlis.is_bin IS NULL)');
        if($idMajlis > 0) {
            $criteria->compare('t.id_majlis', $idMajlis);
        }
        $model = $this->findAll($criteria);
        $i=0;
        foreach ($list as $soalan => $title) {
            $data[$i]['data'] = array(0,0,0,0,0); // set default value for each scale. $array[0] represent scale 1. (index+1)
            foreach ($model as $fieldName => $item) {
                $data[$i]['data'][$item->$soalan-1] += 1;
            }
            $data[$i]['name'] = $title;
            $i++;
        }
        
        return $data;
    }
    
    public function getStatisticPartF($idMajlis=0)
    {
        $data = array();
        if($idMajlis > 0) {
            $criteria = new CDbCriteria();
            $criteria->with = 'majlis';
            $criteria->addCondition('(majlis.is_bin = '. Utils::NOT_DELETED.' OR majlis.is_bin IS NULL)');
            $criteria->compare('t.id_majlis', $idMajlis);
            $model = $this->findAll($criteria);
            
            foreach ($model as $field => $item) {
                $i=1;
                $split = explode(',', $item->pembentangan);
                foreach ($split as $id => $value) {
                    if(!empty($value)) {
                        $exp = explode(':', $value);
                        $data[$exp[0]]['data'][$exp[1]-1] += 1;
                        $data[$exp[0]]['score'][$exp[1]-1] += $exp[1];
                        if($item->peserta->kategori == Peserta::KATEGORI_KERTASKERJA)
                            $data[$exp[0]]['total_f'] += 1;
                    }
                    $i++;
                }
            }
            $c = new CDbCriteria();
            $c->compare('id_majlis', $idMajlis);
            $c->order = 'id';
            $pembentangan = Pembentangan::model()->findAll($c);
            $j=1;
            foreach ($pembentangan as $index => $item) {
                $data[$item->id]['name'] = 'F'.$j;
                for($i=0;$i<5;$i++) {
                    if(!array_key_exists($i, $data[$item->id]['data']))
                        $data[$item->id]['data'][$i] = 0;
                }
                ksort($data[$item->id]['data']);
                $j++;
            }
            return array_values($data);
        }
        return null;
    }
    
    public function getAverageStatisticPartF($idMajlis=0)
    {
        if($idMajlis > 0) {
            foreach($this->getStatisticPartF($idMajlis) as $id => $item)
                $data[] = round(array_sum($item['score']) / $item['total_f']);

            return array(
                array('name' => 'Purata Penilaian', 'data' => $data),
            );
        }
        return null;
    }
}