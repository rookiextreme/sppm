<?php
/* @var $this PembentanganController */
/* @var $data Pembentangan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tajuk')); ?>:</b>
	<?php echo CHtml::encode($data->tajuk); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_majlis')); ?>:</b>
	<?php echo CHtml::encode($data->id_majlis); ?>
	<br />


</div>