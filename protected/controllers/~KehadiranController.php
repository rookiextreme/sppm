<?php

class KehadiranController extends Controller
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
				'actions'=>array('index','view','admin','delete','create','update','pengesahan','reportkehadiran','ajaxsenaraipeserta','ajaxreportkehadiran','pesertamajlis','daftar','ajaxattendanceupdate', 'ajaxattendanceupdate2'),
				'roles'=>array('Sekretariat','Tuan rumah'),
			),
                        array('allow',
                            'actions' => array('qrpengesahan'),
                            'users' => array('*'),
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
		$model=new Kehadiran;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Kehadiran']))
		{
			$model->attributes=$_POST['Kehadiran'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_kehadiran));
		}

		$this->render('pengesahan',array(
			'model'=>$model,
		));
	}
    
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionPengesahan()
	{
		$model = new Majlis;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);
        
		$this->render('pengesahan',array(
			'model'=>$model,
		));
	}
	
	public function actionReportKehadiran()
	{
		$model = new Majlis;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		$this->render('senaraikehadiran',array(
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Kehadiran']))
		{
			$model->attributes=$_POST['Kehadiran'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id_kehadiran));
		}

		$this->render('update',array(
			'model'=>$model,
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
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Kehadiran');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Kehadiran('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Kehadiran']))
			$model->attributes=$_GET['Kehadiran'];

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
		$model=Kehadiran::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='kehadiran-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    
    public function actionAjaxSenaraiPeserta()
	{
        $id = $_POST['Majlis']['id'];
        $searchStr = explode(' ', $_POST['nama']);
        $criteria = new CDbCriteria();
        $criteria->condition = "id_majlis = :id_majlis AND (is_bin IS NULL OR is_bin = :is_bin)";
        $criteria->params = array(":id_majlis" => $id, ":is_bin" => Utils::NOT_DELETED);
        
        $criteriav = new CDbCriteria();
        $criteriav->condition = "id_majlis = :id_majlis";
        $criteriav->params = array(":id_majlis" => $id);
        $jadual = Jadual::model()->findAll($criteria);
        $lawatan = Lawatan::model()->findAll($criteriav);
        if($jadual) {
            $data = Peserta::model()->getKehadiranArr($id, $searchStr);
            $this->renderPartial('_senarai_peserta',array(
                'data'=>$data,
                'jadual'=>$jadual,
                'lawatan'=>$lawatan,
				'count'=>$data['lawatan'],
            ));
        } else {
            echo "<br /><i>Tiada rekod ditemui.</i>";
        }
            
		
	}
    
    public function actionAjaxAttendanceUpdate()
	{
        $done = CHtml::image(Yii::app()->request->baseUrl.'/images/tick2.png');
        $delete = CHtml::image(Yii::app()->request->baseUrl.'/images/wrong.jpg');
        $disable = CHtml::image(Yii::app()->request->baseUrl.'/images/stophand.png');
        
        $idpengguna = $_POST['idpengguna'];
        $idmajlis = $_POST['idmajlis'];
        $idkehadiran = $_POST['idkehadiran'];
        $idlawatan = $_POST['idlawatan'];
        $ganti = $_POST['ganti'];
        $value = $_POST['val'];
        $checkvalval = $_POST['checkval'];
        
        if($ganti == 0) {
            if($value == Kehadiran::STATUS_HADIR) {
                $img = $delete;
                $val = Kehadiran::STATUS_TAK_HADIR;
            } else if($value == Kehadiran::STATUS_TAK_HADIR) {
                $img = $done;
                $val = Kehadiran::STATUS_HADIR;
            }
            if(Kehadiran::model()->updateByPk($idkehadiran, array('kehadiran'=>$val))) {
                echo CHtml::link($img,'',array(
                                        'class'=>'link kedatangan'.$idpengguna,
                                        'id_pengguna'=>$idpengguna,
                                        'id_kehadiran'=>$idkehadiran,
                                        'value'=>$val,
                                        'ganti'=>0,
                                    ));
            }
        } else if($ganti == 1) {
            $gantiStatus=($checkvalval == 'checked')?1:0;
            if(Peserta::model()->updateByPk($idpengguna, array('berpengganti'=>$gantiStatus))) {
                $c = new CDbCriteria();
                $c->condition = "id_majlis = :id_majlis AND id_pengguna = :id_pengguna";
                $c->params = array(":id_majlis" => $idmajlis, ":id_pengguna" => $idpengguna);
                $peserta = Peserta::model()->find($c);
                if($peserta->r_kehadiran) {
                    foreach ($peserta->r_kehadiran as $p) {
                        Kehadiran::model()->updateByPk($p->id_kehadiran, array('kehadiran'=>Kehadiran::STATUS_TAK_HADIR));
                    }
                }
                if($checkvalval == 'checked')
                    echo "-";
            }
            
        }
    }
	
	public function actionAjaxAttendanceUpdate2()
	{
        $done = CHtml::image(Yii::app()->request->baseUrl.'/images/tick2.png');
        $delete = CHtml::image(Yii::app()->request->baseUrl.'/images/wrong.jpg');
        
        $idpengguna = $_POST['idpengguna'];
        $idmajlis = $_POST['idmajlis'];
        $idkehadiran = $_POST['idkehadiran'];
        $idlawatan = $_POST['idlawatan'];
        $ganti = $_POST['ganti'];
        $value = $_POST['val'];
        $checkvalval = $_POST['checkval'];
        
        if($ganti == 0) {
			$xx = Peserta::model()->findByPk($idpengguna);
			if($xx->id_lawatan != $idlawatan){
				$img1 = $done;
			} else if($xx->id_lawatan == $idlawatan) {
				$img1 = $delete;
				$idlawatan = 0;
			} else {
				$img1 = $delete;
			}
			
			if(Peserta::model()->updateByPk($idpengguna, array('id_lawatan'=>$idlawatan))) {
					echo CHtml::link($img1,'',array(
											'class'=>'link1 kedatangan'.$idpengguna,
											'id_pengguna'=>$idpengguna,
											'id_lawatan'=>$idlawatan,
											'value'=>$val,
											'ganti'=>0,
										));
				}
        } else if($ganti == 1) {
            $gantiStatus=($checkvalval == 'checked')?1:0;
            if(Peserta::model()->updateByPk($idpengguna, array('berpengganti'=>$gantiStatus))) {
                $c = new CDbCriteria();
                $c->condition = "id_majlis = :id_majlis AND id_pengguna = :id_pengguna";
                $c->params = array(":id_majlis" => $idmajlis, ":id_pengguna" => $idpengguna);
                $peserta = Peserta::model()->find($c);
                if($peserta->r_kehadiran) {
                    foreach ($peserta->r_kehadiran as $p) {
                        Kehadiran::model()->updateByPk($p->id_kehadiran, array('kehadiran'=>Kehadiran::STATUS_TAK_HADIR));
                    }
                }
                if($checkvalval == 'checked')
                    echo "-";
            }
            
        }
    }
	
	public function actionAjaxReportKehadiran()
	{
        $id = $_POST['Majlis']['id'];
        $criteria = new CDbCriteria();
        $criteria->condition = "id_majlis = :id_majlis AND (is_bin IS NULL OR is_bin = :is_bin)";
        $criteria->params = array(":id_majlis" => $id, ":is_bin" => Utils::NOT_DELETED);
        $criteriap = new CDbCriteria();
        $criteriap->condition = "id_majlis = :id_majlis AND (is_bin IS NULL OR is_bin = :is_bin) AND id_lawatan IS NOT NULL";
        $criteriap->params = array(":id_majlis" => $id, ":is_bin" => Utils::NOT_DELETED);
        $jadual = Jadual::model()->findAll($criteria);
        $peserta = Peserta::model()->findAll($criteriap);
        
        if($jadual) {
            $data = Peserta::model()->getKehadiranArr($id);
        }
        //echo var_dump($peserta);die();
		$this->renderPartial('report',array(
			'data'=>$data,
            'jadual'=>$jadual,
            'peserta'=>$peserta,
		));
	}
        
        public function actionQrpengesahan()
	{
            $id_kehadiran=$_GET['idhadir'];
            $dataupd =  Kehadiran::model()->updateByPk($id_kehadiran, array('kehadiran'=>Kehadiran::STATUS_HADIR));
	}
}
