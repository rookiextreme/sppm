<?php
/* @var $this SubSoalanController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Sub Soalans',
);

$this->menu=array(
	array('label'=>'Create SubSoalan', 'url'=>array('create')),
	array('label'=>'Manage SubSoalan', 'url'=>array('admin')),
);
?>

<h1>Sub Soalans</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
