<?php
/* @var $this PenginapanController */
/* @var $model Penginapan */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_majlis'); ?>
		<?php echo $form->textField($model,'id_majlis'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'penginapan'); ?>
		<?php echo $form->textField($model,'penginapan',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_bin'); ?>
		<?php echo $form->textField($model,'is_bin'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->