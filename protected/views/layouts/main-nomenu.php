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
        <div class="container" id="page"> 
            
            <?php echo $content; ?>

            <div class="clear"></div>

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
