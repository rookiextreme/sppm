<?php
/* @var $this SoalanController */
/* @var $model Soalan */

$this->breadcrumbs=array(
	'Soalans'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Soalan', 'url'=>array('index')),
	array('label'=>'Create Soalan', 'url'=>array('create')),
	array('label'=>'Update Soalan', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Soalan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Soalan', 'url'=>array('admin')),
);
?>

<h1>View Soalan #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tajuk',
		'allowed_peserta',
		'tajuk_pilihan',
		'pilihan',
		'susunan',
		'id_jenis',
	),
)); ?>
