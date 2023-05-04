<?php
/* @var $this PenggantiController */
/* @var $model Pengganti */

$this->breadcrumbs=array(
	'Penggantis'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Pengganti', 'url'=>array('index')),
	array('label'=>'Create Pengganti', 'url'=>array('create')),
	array('label'=>'View Pengganti', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Pengganti', 'url'=>array('admin')),
);
?>

<h1>Update Pengganti <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>