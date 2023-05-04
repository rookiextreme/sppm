<?php
/* @var $this PenggantiController */
/* @var $data Pengganti */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama_pengganti')); ?>:</b>
	<?php echo CHtml::encode($data->nama_pengganti); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email_pengganti')); ?>:</b>
	<?php echo CHtml::encode($data->email_pengganti); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('telefon_pengganti')); ?>:</b>
	<?php echo CHtml::encode($data->telefon_pengganti); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_peserta_asal')); ?>:</b>
	<?php echo CHtml::encode($data->id_peserta_asal); ?>
	<br />


</div>