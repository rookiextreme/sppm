<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Sistem Pengurusan Penilaian Mesyuarat Pegawai Kanan JKR Malaysia',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
//        'application.vendors.phpexcel.PHPExcel',    //*** tambah pada 18/09/2014 by fitkha ***//
//        'ext.yiireport.*',
//        'ext.yiiexcel.*',
//        'ext.phpexcelreader.*',
//        'ext.phpexcel.PHPExcel.*',
    ),
    'modules' => array(
    // uncomment the following to enable the Gii tool

      'gii'=>array(
      'class'=>'system.gii.GiiModule',
      'password'=>'963963',
      // If removed, Gii defaults to localhost only. Edit carefully to taste.
      'ipFilters'=>array('127.0.0.1','::1'),
      ),

    ),

    //import graph
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.extensions.jqBarGraph.*',
        'application.extensions.highcharts.*',
    ),

    // application components
    'components' => array(
        'Date' => array(
            'class' => 'application.components.Date',
            //And integer that holds the offset of hours from GMT e.g. 4 for GMT +4
            'offset' => 4,
        ),
        'mail' => array(
            'class' => 'ext.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'postmaster.1govuc.gov.my',
                'username' => '',
                'password' => '',
                'port' => '25',
//                'host' => 'smtp.gmail.com',
//                'username' => '',
//                'password' => '',
//                'port' => '587',//25
            ),
            'viewPath' => 'application.views.mail',
            'logging' => true,
            'dryRun' => false
        ),
        'ePdf' => array(
            'class' => 'ext.yii-pdf.EYiiPdf',
            'params' => array(
                'mpdf' => array(
                    'librarySourcePath' => 'application.vendors.MPDF54.*',
                    'constants' => array(
                        '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                    ),
                    'class' => 'mpdf', // the literal class filename to be loaded from the vendors folder
                    'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                        'mode'              => '', //  This parameter specifies the mode of the new document.
                        'format'            => 'A4', // format A4, A5, ...
                        'default_font_size' => 0, // Sets the default document font size in points (pt)
                        'default_font'      => '', // Sets the default font-family for the new document.
                        'mgl'               => 10, // margin_left. Sets the page margins for the new document.
                        'mgr'               => 10, // margin_right
                        'mgt'               => 45, // margin_top
                        'mgb'               => 30, // margin_bottom
                        'mgh'               => 9, // margin_header
                        'mgf'               => 9, // margin_footer
                        'orientation'       => 'L', // landscape or portrait orientation
                  )
                ),
                'HTML2PDF' => array(
                    'librarySourcePath' => 'application.vendors.html2pdf.*',
                    'classFile' => 'html2pdf.class.php', // For adding to Yii::$classMap
                    'defaultParams' => array(// More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
                        'orientation' => 'P', // landscape or portrait orientation
                        'format' => 'A4', // format A4, A5, ...
                        'language' => 'en', // language: fr, en, it ...
                        'unicode' => true, // TRUE means clustering the input text IS unicode (default = true)
                        'encoding' => 'UTF-8', // charset encoding; Default is UTF-8
                        'marges' => array(20, 10, 20, 10), // margins by default, in order (left, top, right, bottom)
                    )
                ),
            ),
        ),
        'user' => array(
            'class' => 'WebUser',
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        /*
          'urlManager'=>array(
          'urlFormat'=>'path',
          'rules'=>array(
          '<controller:\w+>/<id:\d+>'=>'<controller>/view',
          '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
          '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
          ),
          ),
         */
        'db1' => array(
            'connectionString' => 'sqlite:' . dirname(__FILE__) . '/../data/testdrive.db',
        ),
        // uncomment the following to use a MySQL database

        'db' => array(
          'connectionString' => 'pgsql:host=10.8.81.11;dbname=sumber;port=5432',
            'username' => 'postgres',
            'password' => 'ayamdarapasartani',
           // 'connectionString' => 'pgsql:host=localhost;dbname=sumber_refid;port=5432',
           // 'username' => 'postgres',
           // 'password' => '',
      //      'emulatePrepare' => true,
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);
