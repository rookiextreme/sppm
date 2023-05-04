<?php
/* @var $this JenisSoalanController */
/* @var $model JenisSoalan */
?>

<h1>View Penilaian #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_majlis',
		'tajuk_soalan',
		'pembentangan',
		'allowed_peserta_pembentangan',
		'ulasan',
		'cadangan',
	),
)); ?>
