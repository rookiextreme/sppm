<?php
/* @var $this PenggantiController */
/* @var $model Pengganti */

$this->breadcrumbs=array(
	'Penggantis'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pengganti', 'url'=>array('index')),
	array('label'=>'Create Pengganti', 'url'=>array('create')),
	array('label'=>'Update Pengganti', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pengganti', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pengganti', 'url'=>array('admin')),
);
?>

<h1>View Pengganti #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nama_pengganti',
		'email_pengganti',
		'telefon_pengganti',
		'id_peserta_asal',
	),
)); ?>
