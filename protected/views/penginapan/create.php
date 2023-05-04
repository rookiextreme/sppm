<?php
/* @var $this PenginapanController */
/* @var $model Penginapan */
?>

<h1>Tambah Penginapan bagi <?php echo Majlis::model()->getFieldByID($_POST['id'],'majlis'); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>