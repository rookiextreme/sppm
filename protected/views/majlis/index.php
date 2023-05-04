<?php
/* @var $this MajlisController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Majlis',
);

$this->menu=array(
	array('label'=>'Create Majlis', 'url'=>array('create')),
	array('label'=>'Manage Majlis', 'url'=>array('admin')),
);
?>

<h1>Majlis</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
