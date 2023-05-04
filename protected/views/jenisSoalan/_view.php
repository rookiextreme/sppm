<?php
/* @var $this JenisSoalanController */
/* @var $data JenisSoalan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_majlis')); ?>:</b>
	<?php echo CHtml::encode($data->id_majlis); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tajuk_soalan')); ?>:</b>
	<?php echo CHtml::encode($data->tajuk_soalan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pembentangan')); ?>:</b>
	<?php echo CHtml::encode($data->pembentangan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allowed_peserta_pembentangan')); ?>:</b>
	<?php echo CHtml::encode($data->allowed_peserta_pembentangan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ulasan')); ?>:</b>
	<?php echo CHtml::encode($data->ulasan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cadangan')); ?>:</b>
	<?php echo CHtml::encode($data->cadangan); ?>
	<br />


</div>