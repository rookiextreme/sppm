<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
        <![endif]-->

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>

    <body>
<!--        <div><img id="banner" src="images/bannerAduan1.png" alt="Banner Image"/></div> -->

        <div class="container" id="page"> 

            <div id="info">
                <?php 
                if (!Yii::app()->user->isGuest) { ?>  
                    <a href="#"><img src="images/icon_down.png" width="20px" /></a>
                    <div class="staffbox">
                        <table class="nobo">
                            <tr>
                                <td width="10%">Nama</td>
                                <th><?php echo Yii::app()->user->getState('nama');?></th>
                            </tr>
                            <tr>
                                <td>Pejabat</td>
                                <th><?php echo Yii::app()->user->getState('waran');?></th>
                            </tr>
                            <tr>
                                <td>Level</td>
                                <?php $role = Yii::app()->user->getState('roles');?>
                                <th><?php echo $role[0];?></th>
                            </tr>
                        </table>
                    </div>
                <?php
                } 
                ?>
            </div>
            
            <div id="header">
                <div id="logo">
                    <div id="contact">
                        <!--<img src="images/phone.png" width="15px" />&nbsp;603 2610 8888&nbsp;&nbsp;&nbsp;<img src="images/email.png" width="15px"></img>&nbsp;aduan@jkr.gov.my-->
                    </div>
                </div>
            </div>
            <!-- header -->

            <div id="mainmenu">
                <?php
                $this->widget('application.extensions.mbmenu.MbMenu', array(
                    'items' => array(
                        array('label' => 'Utama', 'url' => array('/site/index')),
                        array('label' => 'Dashboard', 'visible' => !Yii::app()->user->isGuest, 'url' => array('/survey/dashboard')),
                        array('label'=>'Pentadbir','visible' => !Yii::app()->user->isGuest,'items'=>array(
                            array('label' => 'Pengurusan Majlis', 'url' => array('/majlis/admin')),
                            array('label' => 'Pengesahan Kehadiran', 'url' => array('/kehadiran/pengesahan')),
                            array('label' => 'Pengurusan Penyelaras', 'url' => array('/pengguna/admin'),),
                            array('label' => 'Pengurusan Soalan Penilaian', 'url' => array('/jenisSoalan/admin'),),
                        )),
                        array('label'=>'Laporan','visible' => !Yii::app()->user->isGuest,'items'=>array(
                            array('label' => 'Laporan Survey', 'url' => array('/survey/laporan')),
                            array('label' => 'Senarai Survey', 'url' => array('/survey/admin')),
                            array('label' => 'Kehadiran', 'url' => array('/kehadiran/reportkehadiran')),
                            array('label' => 'Lawatan Tapak', 'url' => array('/kehadiran/reportlawatan')),
                        )),
                        array('label' => 'Login', 'url' => array('/site/login'), 'itemOptions'=>array('style'=>'float:right;margin-right:-20px;'), 'visible' => Yii::app()->user->isGuest),
                        array('label' => 'Logout', 'url' => array('/site/logout'), 'itemOptions'=>array('style'=>'float:right;'), 'visible' => !Yii::app()->user->isGuest)
                    ),
                ));
                ?>
            </div><!-- mainmenu -->
            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('zii.widgets.CBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>

            <?php echo $content; ?>

            <div class="clear"></div>

            <div id="footer">
                Jabatan Kerja Raya dan Kerajaan Malaysia adalah tidak bertanggungjawab ke atas kerugian yang dialami atas penggunaan maklumat yang terkandung di laman ini.<br />
                Sistem Pengurusan Penilaian Mesyuarat Malaysia &copy; <?php echo date('Y');?>. Hakcipta Terpelihara.<br />
                Versi 0.1.<br/>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>

<?php

// Add fancybox
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/js/fancybox/source/jquery.fancybox.css?v=2.0.6', 'screen');
// -- Optionally add helpers - button, thumbnail and/or media
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/fancybox/source/jquery.fancybox.pack.js?v=2.0.6');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/js/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.2', 'screen');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.2');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.0');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/js/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=2.0.6', 'screen');
Yii::app()->clientScript->registerScriptFile(Yii::app()->request->baseUrl . '/js/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=2.0.6');
Yii::app()->clientScript->registerScript('fancybox', " $('.fancybox').fancybox();");

?>
