<?php
/* @var $this JadualController */
/* @var $model Jadual */
?>

<h1>Senarai Jadual <?php echo $model->id; ?> bagi <?php echo Majlis::model()->getFieldByID($model->id_majlis,'majlis'); ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tarikh',
		'daftar_oleh',
		'tkh_daftar',
		'kemaskini_oleh',
		'tkh_kemaskini',
		'flag_aktif',
		'is_bin',
	),
)); ?>
