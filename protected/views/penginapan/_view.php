<?php
/* @var $this PenginapanController */
/* @var $data Penginapan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_majlis')); ?>:</b>
	<?php echo CHtml::encode($data->id_majlis); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('penginapan')); ?>:</b>
	<?php echo CHtml::encode($data->penginapan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('is_bin')); ?>:</b>
	<?php echo CHtml::encode($data->is_bin); ?>
	<br />


</div>