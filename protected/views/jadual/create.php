<?php
/* @var $this JadualController */
/* @var $model Jadual */
?>

<h1>Daftar Jadual bagi <?php echo Majlis::model()->getFieldByID($_POST['id_majlis'],'majlis'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,)); ?>