<?php
/* @var $this SubSoalanController */
/* @var $model SubSoalan */
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
		<?php echo $form->label($model,'id_soalan'); ?>
		<?php echo $form->textField($model,'id_soalan'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'soalan'); ?>
		<?php echo $form->textField($model,'soalan',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->