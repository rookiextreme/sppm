<?php

class SurveyController extends Controller 
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','display','update','admin','preview','laporan','ajaxloadform','ajaxpenilaianpeserta','ajaxlaporanpenilaianpeserta','dashboard','laporanexcel'),
				'roles'=>array('Sekretariat','Tuan rumah'),
			),
			array('allow', 
                'actions'=>array('create'),	
                'users'=>array('*'), 
                        ),
			array('deny',  // deny all users
                'users'=>array('*'),  
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
        
    public function actionDisplay($id) 
    {
        $this->layout = '//layouts/clean';
        $model = $this->loadModel($id);
        $modelM = Majlis::model()->findByPk($model->id_majlis);
        $modelP = Peserta::model()->findByPk($model->id_pengguna);


        $this->render('display', array(
            'model' => $model,
            'modelM' => $modelM,
            'modelP' => $modelP,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate($id)
    {
        $this->layout = '//layouts/main-nomenu';
//        $id_pengguna = Utils::decode($id);buang decode sebab dah tak encode//kadang-kadang silap output
        $id_pengguna = $id;
        $model = new Survey;
        $peserta = Peserta::model()->findByPk($id_pengguna);
        $survey = Survey::model()->findByAttributes(array('id_pengguna'=>$id_pengguna));
        $majlis = Majlis::model()->findByPk($peserta->id_majlis);
        
        if($survey)
            Yii::app()->user->setFlash('SurveyWujud', 'Survey telah diterima, Terima Kasih !!.');
        
        if (isset($_POST['Survey']) && $peserta && !$survey) {
            $penilaian = $_POST['Survey']['markah'];
            $numItems = count($penilaian);
            $i = 0;
            $record = '';
            foreach ($penilaian as $id => $score) {
                $record .= $id . ':' . $score;
                if (++$i != $numItems)
                    $record .= ',';
            }
            $pembentangan = $_POST['Survey']['pembentangan'];
            if($pembentangan) {
                $numItems = count($pembentangan);
                $i = 0;
                $record_pembentangan = '';
                foreach ($pembentangan as $id => $score) {
                    $record_pembentangan .= $id . ':' . $score;
                    if (++$i != $numItems)
                        $record_pembentangan .= ',';
                }
                $_POST['Survey']['pembentangan'] = $record_pembentangan;
            }
            if($_POST['pilihan']) {
                $numItems = count($_POST['pilihan']);
                $i = 0;
                $pilihan = '';
                foreach ($_POST['pilihan'] as $id => $score) {
                    $record_pilihan .= $id . ':' . $score;
                    if (++$i != $numItems)
                        $record_pilihan .= ',';
                }
                $_POST['Survey']['pilihan'] = $record_pilihan;
            }
            $model->attributes = $_POST['Survey'];
            $model->id_majlis = $peserta->id_majlis;
            $model->id_pengguna = (int)$id_pengguna;
            $model->markah = $record;
            try {
                if ($model->save()){
                    Peserta::model()->updateByPk($id_pengguna, array('status_survey' => Survey::FLAG_AKTIF,));
                    Yii::app()->user->setFlash('Survey', 'Survey telah berjaya dimasukkan. Terima Kasih kerana sudi meluangkan masa anda.');
                    //$this->refresh();
                } else {
                    // add error message
                    Yii::app()->user->setFlash('Survey', 'Survey anda tidak berjaya dimasukkan. Sila cuba sebentar lagi.');
                }
            } catch (CDbException $e) {
                $model->addError(null, $e->getMessage());
                $this->refresh();
            }
        }
        
        $this->render('create', array(
            'model' => $model,
            'Majlis' => $majlis,
            'Peserta' => $peserta,
        ));
    }
    
    public function actionPreview()
    {
        if($_POST['id']) {
            $this->layout = '//layouts/clean';
            $model = new Survey;

            $this->render('preview', array(
                'model' => $model,
                'id' => $_POST['id'],
            ));
        } else {
            $this->redirect(array('jenissoalan/admin', 'options' => array("target"=>"_blank")));
        }
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) 
    {
        $model = $this->loadModel($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Survey'])) {
            $model->attributes = $_POST['Survey'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) 
    {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() 
    {
        $dataProvider = new CActiveDataProvider('Survey');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() 
    {
        $model = new Survey('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Survey']))
            $model->attributes = $_GET['Survey'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    public function actionLaporan() 
    {
        $model = new Survey();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Survey']))
            $model->attributes = $_GET['Survey'];

        $this->render('laporan', array(
            'model' => $model,
        ));
    }
    
    public function actionDashboard() {
        $model = new Survey();
        $this->render('dashboard', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Survey::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) 
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'survey-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxPenilaianPeserta()
	{
        $pengguna = Peserta::model()->available()->getPeserta($_POST['Majlis']['id'])->findAll();

		$this->renderPartial('_senarai_penilaian',array(
			'pengguna'=>$pengguna,
		));
	}
        
    public function actionAjaxLaporanPenilaianPeserta()
	{
        $c = new CDbCriteria();
        $c->compare('t.id_majlis', $_POST['Majlis']['id']);
        $c->with = 'peserta';
        $c->compare('peserta.is_bin', Utils::NOT_DELETED);
        $majlis = Majlis::model()->findByPk($_POST['Majlis']['id']);
        $survey = Survey::model()->findAll($c);
        
		$this->renderPartial('_laporan_penilaian',array(
            'majlis'=>$majlis,
            'survey'=>$survey,
		));
	}
    
    public function actionAjaxLoadForm() 
    {
        $idMajlis = $_POST['Survey']['id'];
        $tmp = Survey::model()->getAttendanceList($idMajlis);
        
        $kehadiran = array(
                    array('Hadir', $tmp['hadir']), 
                    array('Tidak Hadir', $tmp['takhadir'])
                );
        $survey = array(
                    array('Selesai', $tmp['selesai']),
                    array('Belum Selesai', $tmp['belum']),
                );
        $data = Survey::model()->getAverageStatistic($idMajlis);
        $partF = Survey::model()->getStatisticPartF($idMajlis);
        $avgPartF = Survey::model()->getAverageStatisticPartF($idMajlis);
        $category = Pembentangan::model()->getCategory($idMajlis);
        $this->renderPartial('dashboard/_layout', array(
            'data' => $data, 
            'survey' => $survey, 
            'kehadiran' => $kehadiran, 
            'partf' => $partF,
            'avgpartf' => $avgPartF,
            'category' => $category,
        ),false,true);
    }

    public function actionLaporanExcel() 
    {
        $c = new CDbCriteria();
        $c->compare('t.id_majlis', $_GET['id']);
        $c->with = 'peserta';
        $c->compare('peserta.is_bin', Utils::NOT_DELETED);
        $survey = Survey::model()->findAll($c);
        $majlis = Majlis::model()->findByPk($_GET['id']);
        
		$this->renderPartial('_laporan_excel',array(
            'majlis'=>$majlis,
            'survey'=>$survey,
		));
    }
    
    public function actionUpdateMarkah($id) {
        $c = new CDbCriteria();
        $c->compare('t.id_majlis',$id);
        $c->order = "id_pengguna";
        $survey = Survey::model()->findAll($c);
        foreach ($survey as $s) {
            $markah = "1:".$s->soalan1.",2:".$s->soalan2.",3:".$s->soalan3.",4:".$s->soalan4.",5:".$s->soalan5.",6:".$s->soalan6.",7:".$s->soalan7.",8:".$s->soalan8.",9:".$s->soalan9.",10:".$s->soalan10;
            $model = Survey::model()->findByPk($s->id);
            $model->markah = $markah;
            $model->save(false);
        }
        //echo "<pre>".print_r($markah,1)."</pre>";die();
    }
}
