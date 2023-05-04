<?php
/* @var $this SubSoalanController */
/* @var $data SubSoalan */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_soalan')); ?>:</b>
	<?php echo CHtml::encode($data->id_soalan); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('soalan')); ?>:</b>
	<?php echo CHtml::encode($data->soalan); ?>
	<br />


</div>