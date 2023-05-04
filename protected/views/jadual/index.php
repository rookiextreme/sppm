<?php
/* @var $this JadualController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Jaduals',
);

$this->menu=array(
	array('label'=>'Create Jadual', 'url'=>array('create')),
	array('label'=>'Manage Jadual', 'url'=>array('admin')),
);
?>

<h1>Jadual</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
