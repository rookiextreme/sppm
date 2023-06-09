<?php
/* @var $this PesertaController */
/* @var $model Peserta */

$this->breadcrumbs=array(
	'Pesertas'=>array('index'),
	$model->id_pengguna,
);

$this->menu=array(
	array('label'=>'List Peserta', 'url'=>array('index')),
	array('label'=>'Create Peserta', 'url'=>array('create')),
	array('label'=>'Update Peserta', 'url'=>array('update', 'id'=>$model->id_pengguna)),
	array('label'=>'Delete Peserta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id_pengguna),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Peserta', 'url'=>array('admin')),
);
?>

<h1>Senarai Peserta #<?php echo $model->id_pengguna; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id_pengguna',
		'nama',
		'nokp',
		'organisasi',
		'kod_waran',
		'tel_pej',
		'email',
		'kod_jabatan',
		'kategori',
	),
)); ?>
