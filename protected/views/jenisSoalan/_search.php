<?php
/* @var $this JenisSoalanController */
/* @var $model JenisSoalan */
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
		<?php echo $form->label($model,'tajuk_soalan'); ?>
		<?php echo $form->textField($model,'tajuk_soalan',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pembentangan'); ?>
		<?php echo $form->textField($model,'pembentangan'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'allowed_peserta_pembentangan'); ?>
		<?php echo $form->textField($model,'allowed_peserta_pembentangan',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ulasan'); ?>
		<?php echo $form->textField($model,'ulasan'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cadangan'); ?>
		<?php echo $form->textField($model,'cadangan'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->