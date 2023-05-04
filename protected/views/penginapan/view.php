<?php
/* @var $this PenginapanController */
/* @var $model Penginapan */

$this->breadcrumbs=array(
	'Penginapans'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Penginapan', 'url'=>array('index')),
	array('label'=>'Create Penginapan', 'url'=>array('create')),
	array('label'=>'Update Penginapan', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Penginapan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Penginapan', 'url'=>array('admin')),
);
?>

<h1>View Penginapan #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_majlis',
		'penginapan',
		'is_bin',
	),
)); ?>
