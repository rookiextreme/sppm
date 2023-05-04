<?php
/* @var $this PenginapanController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Penginapans',
);

$this->menu=array(
	array('label'=>'Create Penginapan', 'url'=>array('create')),
	array('label'=>'Manage Penginapan', 'url'=>array('admin')),
);
?>

<h1>Penginapans</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
