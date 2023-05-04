<?php

class MajlisController extends Controller 
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column1';

    /**
     * @return array action filters
     */
    public function filters() {
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
    public function accessRules() {
        return array(
            array('allow', // allow sekretariat user to perform actions
                'actions' => array('index', 'view', 'admin', 'create', 'update', 'start', 'stop', 'updateisbin', 'daftarkategoripeserta'),
                'roles' => array('Sekretariat'),
            ),
            array('allow', // allow penganjur user to perform  actions
                'actions' => array('admin',),
                'roles' => array('Tuan rumah'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $this->render('view', array(
            'model' => $this->loadModel($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $model = new Majlis;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['Majlis'])) {
            $model->attributes = $_POST['Majlis'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }

    public function actionStart($id) 
    {
        $model = $this->loadModel($id);
        foreach ($model->peserta as $p) {
            $peserta = Peserta::model()->findByPk($p->id_pengguna);
            $doSurvey = FALSE;
            foreach ($peserta->r_kehadiran as $k) {
                if($k->kehadiran && $peserta->status_survey == Peserta::BELUM_SURVEY && $peserta->kategori <> Peserta::KATEGORI_TETAMU) {
                    $doSurvey = true;               
                }
            }
            
            if($doSurvey) {
//              $id_encode = Utils::encode($p->id_pengguna);buang encode sebab kadang2 silap output
                $id_encode = $p->id_pengguna;
                $link = CHtml::link('Survey',$this->createAbsoluteUrl('survey/create',array('id'=>$id_encode)));
                $antispam = ' #'.$p->id_pengguna;
                $this->hantarEmail($link, $peserta, $antispam);
            }
        }
        $model->updateByPk($id, array('flag_survey' => Utils::FLAG_AKTIF,));
        $this->redirect(array('majlis/admin'));
    }

    public function actionStop($id) 
    {
        $this->loadModel($id)->updateByPk($id, array('flag_survey' => Utils::FLAG_TAK_AKTIF,));
        $this->redirect(array('majlis/admin'));
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

        if (isset($_POST['Majlis'])) {
            $model->attributes = $_POST['Majlis'];
            if ($model->save())
                $this->redirect(array('majlis/admin'));
        }

        $this->render('update', array(
            'model' => $model,
        ));
    }
    
    public function actionUpdateIsBin($id)
	{
        $model = $this->loadModel($id);
        $model->is_bin = Utils::DELETED;
        if($model->save(false))
            $this->redirect(array('majlis/admin'));
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
        $dataProvider = new CActiveDataProvider('Majlis');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() 
    {
        $model = new Majlis('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Majlis']))
            $model->attributes = $_GET['Majlis'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) 
    {
        $model = Majlis::model()->findByPk($id);
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'majlis-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function hantarEmail($link, $peserta, $antispam) 
    {
        Yii::import('ext.yii-mail.YiiMailMessage');
        $message = new YiiMailMessage;
        $validator = new CEmailValidator;
        $flag_email = 0;

        $body_email = '<b>Tuan/Puan,</b></br><br>
                   <i>Bagi membolehkan penambahbaikan terhadap '.$peserta->majlis->majlis.',<br />
                   sukacita kiranya dapat tuan memberi maklumbalas dan penilaian.<br />
                   Sila klik '.$link.$antispam.' </a><br /><br />
                   Sekian, terima kasih.</i><br /><br />'.Utils::ALAMAT_BHG_SEKRETARIAT;
        
        $sub_email = 'Borang Kaji Selidik '.$peserta->majlis->majlis.' '.$antispam;
        $message->setBody($body_email, 'text/html');
        $message->subject = $sub_email;
        $to_email=$peserta->email;
        $message->addTo($to_email);
        $message->from = 'BahagianKeurusetiaan@jkr.gov.my';
        if ($flag_email == 0):
            try {
                $result = Yii::app()->mail->send($message);
            } catch (Exception $e) {
                $result = 0;
            }
        endif;
    }

    public function getPeserta($id)
    {
        $model = $this->loadModel($id);
        return $model->peserta;
    }
    
    public function actionDaftarKategoriPeserta() {
        if ($_POST['allowed_peserta'] && $_POST['id_majlis']) {
            $kategori_peserta = $_POST['allowed_peserta'];
            $numItems = count($kategori_peserta);
            $i = 0;
            $data = '';
            foreach ($kategori_peserta as $index => $value) {
                $data .= $value;
                if (++$i < $numItems) {
                    $data .= ",";
                }
            }
            if (!empty($data)) {
                $model = $this->loadModel($_POST['id_majlis']);
                $model->allowed_peserta_pembentangan = $data;
                if ($model->save(false))
                    $this->redirect(array('pembentangan/admin', 'id' => $model->id));
            }
        } else if (!$_POST['allowed_peserta']) {
            $this->redirect(array('pembentangan/admin', 'id' => $_POST['id_majlis'], 'error' => TRUE));
        }
    }
}
