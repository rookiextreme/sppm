<?php
/* @var $this SubSoalanController */
/* @var $model SubSoalan */

$this->breadcrumbs=array(
	'Sub Soalans'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List SubSoalan', 'url'=>array('index')),
	array('label'=>'Create SubSoalan', 'url'=>array('create')),
	array('label'=>'Update SubSoalan', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete SubSoalan', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage SubSoalan', 'url'=>array('admin')),
);
?>

<h1>View SubSoalan #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_soalan',
		'soalan',
	),
)); ?>
