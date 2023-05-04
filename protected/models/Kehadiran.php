<?php

/**
 * This is the model class for table "socdb.kehadiran".
 *
 * The followings are the available columns in table 'socdb.kehadiran':
 * @property integer $id_kehadiran
 * @property integer $id_jadual
 * @property integer $id_pengguna
 * @property boolean $kehadiran
 *
 * The followings are the available model relations:
 * @property Jadual $idJadual
 * @property Pengguna $idPengguna
 */
class Kehadiran extends CActiveRecord
{
    
    const STATUS_HADIR = 1;
    const STATUS_TAK_HADIR = 0;
    
    public $statusKehadiran = array(
            self::STATUS_HADIR => 'Hadir',
            self::STATUS_TAK_HADIR => 'Tak Hadir',
    );

    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'socdb.kehadiran';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_jadual, id_pengguna', 'required'),
			array('id_jadual, id_pengguna, kehadiran', 'numerical', 'integerOnly'=>true),
			array('kehadiran', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id_kehadiran, id_jadual, id_pengguna, kehadiran', 'safe', 'on'=>'search'),
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
			'peserta' => array(self::BELONGS_TO, 'Peserta', 'id_pengguna'),
			'jadual' => array(self::BELONGS_TO, 'Jadual', 'id_jadual'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id_kehadiran' => 'Id Kehadiran',
			'id_jadual' => 'Id Jadual',
			'id_pengguna' => 'Id Pengguna',
			'kehadiran' => 'Kehadiran',
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

		$criteria->compare('id_kehadiran',$this->id_kehadiran);
		$criteria->compare('id_jadual',$this->id_jadual);
		$criteria->compare('id_pengguna',$this->id_pengguna);
		$criteria->compare('kehadiran',$this->kehadiran);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Kehadiran the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function insertFromPeserta($idMajlis,$idPengguna)
    {
        $majlis = Majlis::model()->findByPk($idMajlis);
        $model = new Kehadiran();
        if($majlis) {
            foreach ($majlis->jadual as $j) {
                $model->setIsNewRecord(true);
                $model->setPrimaryKey(NULL);
                $model->id_jadual = $j->id;
                $model->id_pengguna = $idPengguna;
                $model->save(false);
                
            }
        }
    }
    
    public function insertFromJadual($idMajlis,$idJadual)
    {
        $c = new CDbCriteria();
        $c->compare('id_majlis', $idMajlis);
        $peserta = Peserta::model()->findAll($c);
        if($peserta) {
            $model = new Kehadiran();
            foreach ($peserta as $p) {
                $a['id jadual'][]=$idJadual;
                $a['id pengguna'][]=$p->id_pengguna;
                $model->setIsNewRecord(true);
                $model->setPrimaryKey(NULL);
                $model->id_jadual = $idJadual;
                $model->id_pengguna = $p->id_pengguna;
                $model->save(false);
            }
        }
    }
}
