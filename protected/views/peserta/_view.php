<?php
/* @var $this PesertaController */
/* @var $data Peserta */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pengguna')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id_pengguna), array('view', 'id'=>$data->id_pengguna)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nama')); ?>:</b>
	<?php echo CHtml::encode($data->nama); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nokp')); ?>:</b>
	<?php echo CHtml::encode($data->nokp); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('organisasi')); ?>:</b>
	<?php echo CHtml::encode($data->organisasi); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kod_waran')); ?>:</b>
	<?php echo CHtml::encode($data->kod_waran); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tel_pej')); ?>:</b>
	<?php echo CHtml::encode($data->tel_pej); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('email')); ?>:</b>
	<?php echo CHtml::encode($data->email); ?>
	<br />

</div>