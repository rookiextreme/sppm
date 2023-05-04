<?php
/* @var $this SurveyController */
/* @var $data Survey */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tkh_survey')); ?>:</b>
	<?php echo CHtml::encode($data->tkh_survey); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_pengguna')); ?>:</b>
	<?php echo CHtml::encode($data->id_pengguna); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('markah')); ?>:</b>
	<?php echo CHtml::encode($data->markah); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('id_permohonan')); ?>:</b>
	<?php echo CHtml::encode($data->id_permohonan); ?>
	<br />


</div>