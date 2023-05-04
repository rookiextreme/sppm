<?php

class PesertaController extends Controller {

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
            array('allow', // allow admin user to perform 'admin' and 'delete' actions
                'actions' => array('index', 'view', 'admin', 'create', 'update', 'maklumbalas', 'updateisbin', 'ajaxloadform', 'ajaxloadformawam', 'ajaxdaftarpeserta', 'ajaxdaftarpesertabengkel', 'ajaxdaftarpesertakertaskerja', 'ajaxdaftarpesertatetamu', 'ajaxmaklumbalaskehadiran', 'pesertamajlis', 'daftar', 'daftarAwam', 'daftarKategoriPeserta'),
                'roles' => array('Sekretariat', 'Tuan rumah'),
            ),
            array('allow',
                'actions' => array('updatekehadiran','maklumbalas', 'daftarAwam', 'ajaxloadform', 'ajaxloadformawam'),
                'users' => array('*'),
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
        $model = new Peserta;
        $majlis = Majlis::model()->findByPk($_GET['id']);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Peserta'])) {
            $model->attributes = $_POST['Peserta'];
            $jabatan = Jabatan::model()->findByPk((int) $model->kod_jabatan);
            $model->organisasi = $model->organisasi . ', ' . $jabatan->keterangankod;
            $kakitangan = ListPegawai::model()->findByAttributes(array('nokp' => $model->nokp));
            if ($majlis->pengesahan_kehadiran != 1)
                $model->status = Peserta::STATUS_AKAN_HADIR;

            if ($kakitangan) {
                $model->addError('nama', "$kakitangan->nokp adalah kakitangan JKR. Sila daftar melalui pendaftaran kakitangan.");
            } else {
                if ($model->save()) {
                    if ($majlis->pengesahan_kehadiran == 1) {
                        $this->email($model->email, $model->primaryKey, $majlis->majlis);
                    } else {
                        Kehadiran::model()->insertFromPeserta($majlis->id, $model->primaryKey);
                    }
                    $this->redirect(array('pesertamajlis', 'id' => $majlis->id));
                }
            }
        }

        $this->render('create', array(
            'model' => $model,
            'majlis' => $majlis,
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionDaftar() {
        $model = new Peserta;
        $majlis = Majlis::model()->findByPk($_GET['id']);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Peserta'])) {
            $model->attributes = $_POST['Peserta'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_pengguna));
        }

        $this->render('daftar', array(
            'model' => $model,
            'majlis' => $majlis,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $majlis = Majlis::model()->findByPk($model->id_majlis);
        $penginapan = Penginapan::model()->findByPk($_POST['Peserta']['id_penginapan']);
        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);
        $penginapan_sebelum = $model->id_penginapan;

        if (isset($_POST['Peserta'])) {
            $model->attributes = $_POST['Peserta'];
            $model->id_penginapan = $model->attributes = $_POST['Peserta']['id_penginapan'];
            if ($model->save() && ($model->id_penginapan == NULL || $_POST['Peserta']['id_penginapan'] == $penginapan_sebelum )) {
                $this->redirect(array('pesertamajlis', 'id' => $model->id_majlis));
            } else if ($model->save() && ($model->id_penginapan <> NULL || $_POST['Peserta']['id_penginapan'] <> $penginapan_sebelum)) {
                $antispam = ' #' . $model->id_pengguna . '-' . rand(0, 999);
                $this->hantarEmailPenginapan($model->email, $antispam, $penginapan->penginapan, $majlis->majlis);
                $this->redirect(array('pesertamajlis', 'id' => $majlis->id));
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }

    public function actionMaklumbalas($id) {
        $this->layout = '//layouts/main-nomenu';
        $id_peserta = Utils::decode($id);
        $model = $this->loadModel($id_peserta);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Peserta'])) {
            $model->attributes = $_POST['Peserta'];
            if((int)$_POST['Peserta']['status'] == Peserta::STATUS_TIDAK_HADIR_BEPENGGANTI) {
                $model->scenario = "pengganti";
            } else {
                for($i=0;$i<count($_POST['nama']);$i++) {
                    $keluarga = new Keluarga();
                    $keluarga->nama = $_POST['nama'][$i];
                    $keluarga->umur = $_POST['umur'][$i];
                    $keluarga->jantina = $_POST['jantina'][$i];
                    $keluarga->hubungan = $_POST['hubungan'][$i];
                    $keluarga->id_peserta = $id_peserta;
                    $keluarga->save(false);
                }
                $model->no_tel = $_POST['Peserta']['no_tel'];
                //$model->tkh_checkin = $_POST['Peserta']['tkh_checkin'];
                //$model->tkh_checkout = $_POST['Peserta']['tkh_checkout'];
                //$model->masa_ketibaan = $_POST['Peserta']['masa_ketibaan'];
                //$model->masa_berlepas = $_POST['Peserta']['masa_berlepas'];
                $model->nama_pengganti = NULL;
                $model->email_pengganti = NULL;
                $model->tel_pengganti = NULL;
            }
            if ($model->save()) {
                if($model->status == Peserta::STATUS_AKAN_HADIR)
                    Kehadiran::model()->insertFromPeserta($model->id_majlis, $model->primaryKey);
                Yii::app()->user->setFlash('maklumbalas', "Borang maklumbalas telah berjaya dihantar.");
            }
        }

        $this->render('maklumbalas', array(
            'model' => $model,
            'enable' => $enable,
        ));
    }

    public function actionUpdateIsBin($id) {
        $model = $this->loadModel($id);
        $model->is_bin = Utils::DELETED;
        if ($model->save(false))
            $this->redirect(array('peserta/pesertamajlis', 'id' => $model->id_majlis));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        $this->loadModel($id)->delete();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Peserta');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Peserta('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Peserta']))
            $model->attributes = $_GET['Peserta'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Peserta::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pengguna-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionAjaxDaftarPeserta() {
        $kategori = $_POST['kategori'];
        $idMajlis = $_POST['id'];
        $searchStr = $_POST['searchStr'];
        $nokp = $_POST['nokp'];
        $profile = ListPegawai::model()->findByAttributes(array('nokp' => $nokp));
        $majlis = Majlis::model()->findByPk($idMajlis);
        if ($profile) {
            $model = new Peserta();
            $model->nama = $profile->nama;
            $model->nokp = $profile->nokp;
            $model->gred = $profile->kod_gred;
            $model->jantina = $profile->jantina;
            $model->email = $profile->email;
            $model->kod_waran = $profile->kod_waran;
            $model->id_majlis = $majlis->id;
            $model->kategori = $kategori;
            $model->kakitangan = Peserta::KAKITANGAN_JKR;
            $model->organisasi = LWaranPej::model()->getFullWaranName($profile->kod_waran);
            $model->kod_jabatan = Jabatan::DDSA_JKR;
            if ($majlis->pengesahan_kehadiran != 1)
                $model->status = Peserta::STATUS_AKAN_HADIR;

            $c = new CDbCriteria();
            $c->condition = "id_majlis = :id_majlis AND nokp = :nokp AND is_bin <> :is_bin";
            $c->params = array(":id_majlis" => $majlis->id, ":nokp" => $nokp, ":is_bin" => Utils::DELETED);
            $peserta = Peserta::model()->find($c);

            if ($peserta) {
                echo "<br /><div class='flash-error'>Peserta $profile->nama ($profile->nokp) telah wujud.</div>";
            } else if (!filter_var($profile->email, FILTER_VALIDATE_EMAIL)) {
                echo "<br /><div class='flash-error'>Email $profile->nama ($profile->email) tidak sah. Sila kemaskini alamat email di dalam Sistem MyKJ.</div>";
            } else if ($model->save()) {
                if ($majlis->pengesahan_kehadiran == 1) {
                    $this->email($profile->email, $model->primaryKey, $majlis->majlis);
                } else {
                    // add kehadiran for peserta with status "Akan Hadir" (pengesahan kehadiran is not required)
                    Kehadiran::model()->insertFromPeserta($majlis->id, $model->primaryKey);
                }
                echo "<br /><div class='flash-success'>Peserta $profile->nama ($profile->nokp) telah berjaya didaftarkan.</div>";
            }

            $list = new ListPegawai();
            $this->renderPartial('listpegawai', array(
                'model' => $list,
                'string' => $searchStr,
                'id_majlis' => $majlis->id,
                    ), false, true);
        }
    }

    private function email($emailAddress, $id_peserta, $title) {
        $id_encode = Utils::encode($id_peserta);
        $link = CHtml::link('Maklumbalas Kehadiran',$this->createAbsoluteUrl('peserta/maklumbalas',array('id'=>$id_encode)));
        $antispam = ' #' . $id_peserta;
        $this->hantarEmail($link, $emailAddress, $antispam, $title);
    }

    public function actionAjaxLoadForm() {
        $model = new ListPegawai();

        if (empty($_POST['Peserta']['nama'])) {
            $error = CActiveForm::validate($model);
            if ($error != '[]') {
                $errorMessage = CJavaScript::jsonDecode($error);
                echo "<br /><div class='flash-error'>Ruang carian perlu diisi.</div>";
            }
            Yii::app()->end();
        } else if (strlen($_POST['Peserta']['nama']) < 3) {
            $error = CActiveForm::validate($model);
            if ($error != '[]') {
                $errorMessage = CJavaScript::jsonDecode($error);
                echo "<br /><div class='flash-error'>Sila isi sekurang-kurangnya 3 aksara.</div>";
            }
            Yii::app()->end();
        } else {
            $this->renderPartial('listpegawai', array(
                'model' => $model,
                'string' => $_POST['Peserta']['nama'],
                'id_majlis' => $_POST['Peserta']['id'],
                    ), false, true);
        }
    }

    public function actionPesertaMajlis($id, $error = false) {
        $model = new Peserta;
        $model->unsetAttributes();
        if (isset($_GET['Peserta']))
            $model->attributes = $_GET['Peserta'];

        $majlis = Majlis::model()->findByPk($id);
        $this->render('senarai_peserta', array(
            'model' => $model,
            'majlis' => $majlis,
            'error' => $error,
        ));
    }

    public function hantarEmail($link, $email_peserta, $antispam, $majlis) {
        Yii::import('ext.yii-mail.YiiMailMessage');
        $message = new YiiMailMessage;
        $validator = new CEmailValidator;
        $flag_email = 0;

        $body_email = '<b>YBhg. Datuk/Dato/Tuan/Puan,</b></br><br>
                   <i>Dengan segala hormatnya YBhg. Datuk/Dato/Tuan/Puan dijemput untuk menghadiri ' . $majlis . ',<br>
                   Adalah dipohon jasa baik YBhg. Datuk/Dato/Tuan/Puan memberi maklumbalas kehadiran Mejlis tersebut melalui ' . $link . $antispam . ' </a><br><br>
                   Sekian, terima kasih.</i><br><br>'.Utils::ALAMAT_BHG_SEKRETARIAT;

        $sub_email = 'Borang Maklumbalas kehadiran' . $antispam;
        $message->setBody($body_email, 'text/html');
        $message->subject = $sub_email;
        $to_email = $email_peserta;
        $message->addTo($to_email);
        $message->from = 'BahagianKeurusetiaan@jkr.gov.my';

        if ($flag_email == 0) {
            try {
                $result = Yii::app()->mail->send($message);
            } catch (Exception $e) {
                $result = 0;
            }
        }
    }

    public function hantarEmailPenginapan($email_peserta, $antispam, $tempat, $majlis) {
        Yii::import('ext.yii-mail.YiiMailMessage');
        $message = new YiiMailMessage;
        $validator = new CEmailValidator;
        $flag_email = 0;

        $body_email = '<b>Tuan/Puan,</b></br><br>
                   <i>Adalah dimaklumkan bahawa penginapan tuan/puan untuk ' . $majlis . ' telah ditetapkan<br>
                   Sukacita dimaklumkan bahawa tempat penginapan tuan/puan adalah.' . $tempat . $antispam . '<br>
                   Sekian, terima kasih.</i><br><br>'.Utils::ALAMAT_BHG_SEKRETARIAT;

        $sub_email = 'Makluman Penginapan Peserta ' . $majlis . ' ' . $antispam;
        $message->setBody($body_email, 'text/html');
        $message->subject = $sub_email;
        $to_email = $email_peserta;
        $message->addTo($to_email);
        $message->from = 'BahagianKeurusetiaan@jkr.gov.my';
        if ($flag_email == 0) {
            try {
                $result = Yii::app()->mail->send($message);
            } catch (Exception $e) {
                $result = 0;
            }
        }
    }

    public function actionDaftarKategoriPeserta() {
        if ($_POST['kat_peserta'] && $_POST['id_majlis']) {
            $kategori_peserta = $_POST['kat_peserta'];
            $numItems = count($kategori_peserta);
            if ($numItems > 3)
                $this->redirect(array('pesertamajlis', 'id' => $_POST['id_majlis'], 'error' => TRUE));

            $i = 0;
            $data = '';
            foreach ($kategori_peserta as $index => $value) {
                $data .= $value;
                if (++$i < $numItems) {
                    $data .= ",";
                }
            }
            if (!empty($data)) {
                $model = Majlis::model()->findByPk($_POST['id_majlis']);
                $model->kategori_peserta = $data;
                if ($model->save(false))
                    $this->redirect(array('pesertamajlis', 'id' => $model->id));
            }
        } else if (!$_POST['kat_peserta']) {
            $this->redirect(array('pesertamajlis', 'id' => $_POST['id_majlis'], 'error' => TRUE));
        }
    }

    public function actionDaftarAwam() {
        $this->layout = '//layouts/main-nomenu';
        $model = new Peserta;
        $majlis = Majlis::model()->findByPk($_GET['id']);

        // Uncomment the following line if AJAX validation is needed
        $this->performAjaxValidation($model);

        if (isset($_POST['Peserta'])) {
            $model->attributes = $_POST['Peserta'];
            if ($model->save())
                $this->redirect(array('view', 'id' => $model->id_pengguna));
        }

        $this->render('daftarawam', array(
            'model' => $model,
            'majlis' => $majlis,
        ));
    }

    public function actionAjaxLoadFormAwam() {
        $model = new ListPegawai();

        if (empty($_POST['Peserta']['nama'])) {
            $error = CActiveForm::validate($model);
            if ($error != '[]') {
                $errorMessage = CJavaScript::jsonDecode($error);
                echo "<br /><div class='flash-error'>Ruang carian perlu diisi.</div>";
            }
            Yii::app()->end();
        } else if (strlen($_POST['Peserta']['nama']) < 3) {
            $error = CActiveForm::validate($model);
            if ($error != '[]') {
                $errorMessage = CJavaScript::jsonDecode($error);
                echo "<br /><div class='flash-error'>Sila isi sekurang-kurangnya 3 aksara.</div>";
            }
            Yii::app()->end();
        } else {
            $this->renderPartial('listpegawaiawam', array(
                'model' => $model,
                'string' => $_POST['Peserta']['nama'],
                'id_majlis' => $_POST['Peserta']['id'],
                    ), false, true);
        }
    }
}
