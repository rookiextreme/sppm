<?php
/* @var $this SoalanController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Soalans',
);

$this->menu=array(
	array('label'=>'Create Soalan', 'url'=>array('create')),
	array('label'=>'Manage Soalan', 'url'=>array('admin')),
);
?>

<h1>Soalans</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
