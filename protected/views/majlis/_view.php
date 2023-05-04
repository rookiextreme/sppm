<?php
/* @var $this MajlisController */
/* @var $data Majlis */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('majlis')); ?>:</b>
	<?php echo CHtml::encode($data->majlis); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('penganjur')); ?>:</b>
	<?php echo CHtml::encode($data->penganjur); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('flag_aktif')); ?>:</b>
	<?php echo CHtml::encode($data->flag_aktif); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_bin')); ?>:</b>
	<?php echo CHtml::encode($data->is_bin); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('kemaskini_oleh')); ?>:</b>
	<?php echo CHtml::encode($data->kemaskini_oleh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tkh_kemaskini')); ?>:</b>
	<?php echo CHtml::encode($data->tkh_kemaskini); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('daftar_oleh')); ?>:</b>
	<?php echo CHtml::encode($data->daftar_oleh); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tkh_daftar')); ?>:</b>
	<?php echo CHtml::encode($data->tkh_daftar); ?>
	<br />

	*/ ?>

</div>