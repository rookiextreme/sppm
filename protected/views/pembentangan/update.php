<?php
/* @var $this PembentanganController */
/* @var $model Pembentangan */
?>

<h1>
    Kemaskini Pembentangan <?php echo $model->id; ?> bagi <?php echo Majlis::model()->getFieldByID($model->id_majlis,'majlis'); ?>
</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>