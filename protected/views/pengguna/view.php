<?php
/* @var $this PenggunaController */
/* @var $model Pengguna */
?>

<h1>Senarai Pengguna #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nama',
		'nokp',
		'organisasi',
		'tel_pej',
		'email',
		'peranan',
	),
)); ?>
