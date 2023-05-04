<?php
/* @var $this JenisSoalanController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Jenis Soalans',
);

$this->menu=array(
	array('label'=>'Create JenisSoalan', 'url'=>array('create')),
	array('label'=>'Manage JenisSoalan', 'url'=>array('admin')),
);
?>

<h1>Jenis Soalans</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
