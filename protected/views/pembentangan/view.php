<?php
/* @var $this PembentanganController */
/* @var $model Pembentangan */

$this->breadcrumbs=array(
	'Pembentangans'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Pembentangan', 'url'=>array('index')),
	array('label'=>'Create Pembentangan', 'url'=>array('create')),
	array('label'=>'Update Pembentangan', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Pembentangan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Pembentangan', 'url'=>array('admin')),
);
?>

<h1>Senarai Pembentangan #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'tajuk',
		'id_majlis',
	),
)); ?>
