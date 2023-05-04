<?php
/* @var $this JadualController */
/* @var $model Jadual */
?>

<h1>Kemaskini Jadual <?php echo $model->id; ?> bagi <?php echo Majlis::model()->getFieldByID($model->id_majlis,'majlis'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>