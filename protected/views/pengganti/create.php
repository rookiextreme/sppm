<?php
/* @var $this PenggantiController */
/* @var $model Pengganti */

$this->breadcrumbs=array(
	'Penggantis'=>array('index'),
	'Create',
);

//$this->menu=array(
//	array('label'=>'List Pengganti', 'url'=>array('index')),
//	array('label'=>'Manage Pengganti', 'url'=>array('admin')),
//);
?>

<h1>Maklumbalas Kehadiran</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>