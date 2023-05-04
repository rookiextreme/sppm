<?php
/* @var $this PembentanganController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pembentangans',
);

$this->menu=array(
	array('label'=>'Create Pembentangan', 'url'=>array('create')),
	array('label'=>'Manage Pembentangan', 'url'=>array('admin')),
);
?>

<h1>Pembentangan</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
