<?php

class JadualController extends Controller
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
				'actions'=>array('index','admin','create','updateisbin'),
				'roles'=>array('Sekretariat'),
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
		$model=new Jadual;
        if(isset($_POST['id_majlis']))
            $model->id_majlis = $_POST['id_majlis'];
        
        if(isset($_POST['Jadual'])) {
            $model->id_majlis = $_POST['Jadual']['id_majlis'];
            $error=false;
            if(empty($_POST['Jadual']['tkh_mula'])) {
                $model->addError('tkh_mula', 'Tarikh mula tak lengkap.');
                $error = true;
            } 
            if(empty($_POST['Jadual']['tkh_tamat'])) {
                $model->addError('tkh_tamat', 'Tarikh tamat tak lengkap.');
                $error = true;
            } 
            if(strtotime ($_POST['Jadual']['tkh_tamat']) < strtotime($_POST['Jadual']['tkh_mula'])) {
                $model->addError('tarikh', 'Tarikh tamat tidak boleh kurang daripada tarikh mula.');
                $error = true;
            } 
            
            $majlis = Majlis::model()->findByPk($_POST['Jadual']['id_majlis']);
            if(!$majlis) {
                $model->addError('tarikh', 'Majlis tidak wujud. Sila daftar majlis terlebih dahulu.');
                $error = true;
            }
            
            if(Jadual::model()->checkJadualExist($majlis->available_jadual,$_POST['Jadual']['tkh_mula'],$_POST['Jadual']['tkh_tamat'])) {
                $model->addError('tarikh', 'Tarikh telah wujud. Sila daftar tarikh lain.');
                $error = true;
            }
            
            if(!$error) {
                $startDate = Yii::app()->dateFormatter->format("yyyy-MM-dd", strtotime($this->getDate($_POST['Jadual']['tkh_mula'])));
                $endDate = Yii::app()->dateFormatter->format("yyyy-MM-dd", strtotime($this->getDate($_POST['Jadual']['tkh_tamat'])));
                $date = Jadual::model()->createDateRangeArray($startDate, $endDate);

                foreach ($date as $d) {
                    $model->setIsNewRecord(true);
                    $model->setPrimaryKey(NULL);
                    $_POST['Jadual']['tarikh'] = $d;
                    $model->attributes=$_POST['Jadual'];
                    if($model->save(false)) {
                        Kehadiran::model()->insertFromJadual($model->id_majlis, $model->primaryKey);
                    }
                }
                $this->redirect(array('majlis/view','id'=>$model->id_majlis));
            }
        } 
        
        $this->render('create',array(
                'model'=>$model,
            ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        var_dump($id);die();
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Jadual']))
		{
			$model->attributes=$_POST['Jadual'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
    
    public function actionUpdateIsBin($id)
	{
        $model = $this->loadModel($id);
        $model->is_bin = Utils::DELETED;
        if($model->save(false)) {
            foreach ($model->r_kehadiran as $k) {
                $c = new CDbCriteria();
                $c->compare('id_jadual', $id);
                $c->compare('id_pengguna', $k->id_pengguna);
                $kehadiran = Kehadiran::model()->find($c);
                $kehadiran->attributes = array('kehadiran'=>Kehadiran::STATUS_TAK_HADIR);
                $kehadiran->save();
            }
            $this->redirect(array('majlis/view','id'=>$model->id_majlis));
        }
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

//		 if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Jadual');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Jadual('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Jadual']))
			$model->attributes=$_GET['Jadual'];

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
		$model=Jadual::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='jadual-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    protected function getDate($date)
    {
        if($date)
            return $date;
        else
            return date("Y-m-d H:i:s");
    }
}
