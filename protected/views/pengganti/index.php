<?php
/* @var $this PenggantiController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Penggantis',
);

$this->menu=array(
	array('label'=>'Create Pengganti', 'url'=>array('create')),
	array('label'=>'Manage Pengganti', 'url'=>array('admin')),
);
?>

<h1>Penggantis</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
