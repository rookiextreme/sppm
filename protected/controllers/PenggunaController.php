<?php

class PenggunaController extends Controller
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
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('index','view','admin','update','delete','updateisbin','ajaxloadform','ajaxdaftarsekretariat','ajaxdaftarpenganjur','ajaxdaftarvip','daftar'),
                'roles'=>array('Sekretariat','Tuan rumah'),
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

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Pengguna;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Pengguna']))
		{
			$model->attributes=$_POST['Pengguna'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
    
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionDaftar()
	{
		$model=new Pengguna;
        $majlis=Majlis::model()->findByPk($_GET['id']);

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Pengguna']))
		{
			$model->attributes=$_POST['Pengguna'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('daftar',array(
			'model'=>$model,
			'majlis'=>$majlis,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Pengguna']))
		{
			$model->attributes=$_POST['Pengguna'];
			if($model->save())
				$this->redirect(array('admin',));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
    
    public function actionUpdateIsBin($id)
	{
        $model = $this->loadModel($id);
        $model->is_bin = Utils::DELETED;
        if($model->save(false))
            $this->redirect(array('pengguna/admin'));
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Pengguna');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Pengguna('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Pengguna']))
			$model->attributes=$_GET['Pengguna'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Pengguna::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='pengguna-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionajaxDaftarSekretariat() 
    {
        $peranan = Pengguna::ROLE_SEKRETARIAT;
        return $this->actionajaxDaftarPenyelaras($peranan);
    }
    
    public function actionajaxDaftarPenganjur() 
    {
        $peranan = Pengguna::ROLE_PENGANJUR;
        return $this->actionajaxDaftarPenyelaras($peranan);
    }
    
    public function actionajaxDaftarVip() 
    {
        $peranan = Pengguna::ROLE_KHAS;
        return $this->actionajaxDaftarPenyelaras($peranan);
    }
    
    private function actionajaxDaftarPenyelaras($peranan) 
    {
        $searchStr = $_POST['searchStr'];
        $nokp = $_POST['nokp'];
        $profile = ListPegawai::model()->findByAttributes(array('nokp'=>$nokp));
        
        if($profile) {
            $model = new Pengguna();
            $model->nama = $profile->nama;
            $model->nokp = $profile->nokp;
            $model->jantina = $profile->jantina;
            $model->tel_pej = $profile->tel_pejabat;
            $model->email = $profile->email;
            $model->kod_waran = $profile->kod_waran;
            $model->peranan = $peranan;
            $model->organisasi = LWaranPej::model()->getFullWaranName($profile->kod_waran);
            $c = new CDbCriteria();
            $c->condition = "nokp = :nokp";
            $c->params = array(":nokp" => $nokp);
            $pengguna = Pengguna::model()->find($c);
            if($pengguna) {
                echo "<br /><div class='flash-error'>$profile->nama ($profile->nokp) telah wujud.</div>";
            } else if($model->save()) {
                echo "<br /><div class='flash-success'>$profile->nama ($profile->nokp) telah berjaya didaftarkan.</div>";
            }
            $list = new ListPegawai();
            $this->renderPartial('listpegawai', array(
                        'model' => $list,
                        'string' => $searchStr,
                    ),false,true);
        }
    }
    
    public function actionajaxLoadForm() 
    {
        $model = new ListPegawai();
        
        if(empty($_POST['Pengguna']['nama'])) {
            $error = CActiveForm::validate($model);
            if($error!='[]') {
                $errorMessage = CJavaScript::jsonDecode($error);
                echo "<br /><div class='flash-error'>Ruang carian perlu diisi.</div>";
            }
            Yii::app()->end();
        } else if(strlen($_POST['Pengguna']['nama']) < 3) {
            $error = CActiveForm::validate($model);
            if($error!='[]') {
                $errorMessage = CJavaScript::jsonDecode($error);
                echo "<br /><div class='flash-error'>Sila isi sekurang-kurangnya 3 aksara.</div>";
            }
            Yii::app()->end();
        } else {
            $this->renderPartial('listpegawai', array(
                    'model' => $model,
                    'string' => $_POST['Pengguna']['nama'],
                ),false,true);
        }
    }
    
    public function actionPesertaMajlis($id)
	{
        $model = new Pengguna;
        $model->unsetAttributes();
        $majlis = Majlis::model()->findByPk($id);
		$this->render('senarai_peserta',array(
			'model'=>$model,
            'majlis'=>$majlis,
		));
	}
}
