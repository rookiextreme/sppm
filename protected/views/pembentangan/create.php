<?php
/* @var $this PembentanganController */
/* @var $model Pembentangan */
?>

<h1>
    Daftar Pembentangan bagi <?php echo Majlis::model()->getFieldByID($_POST['id'],'majlis'); ?>
</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>