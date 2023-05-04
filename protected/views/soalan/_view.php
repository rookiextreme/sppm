<?php
/* @var $this SoalanController */
/* @var $data Soalan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tajuk')); ?>:</b>
	<?php echo CHtml::encode($data->tajuk); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('allowed_peserta')); ?>:</b>
	<?php echo CHtml::encode($data->allowed_peserta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tajuk_pilihan')); ?>:</b>
	<?php echo CHtml::encode($data->tajuk_pilihan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('pilihan')); ?>:</b>
	<?php echo CHtml::encode($data->pilihan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('susunan')); ?>:</b>
	<?php echo CHtml::encode($data->susunan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_jenis')); ?>:</b>
	<?php echo CHtml::encode($data->id_jenis); ?>
	<br />


</div>