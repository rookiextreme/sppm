<?php
/* @var $this SoalanController */
/* @var $model Soalan */
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
		<?php echo $form->label($model,'tajuk'); ?>
		<?php echo $form->textField($model,'tajuk',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'allowed_peserta'); ?>
		<?php echo $form->textField($model,'allowed_peserta',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tajuk_pilihan'); ?>
		<?php echo $form->textField($model,'tajuk_pilihan',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pilihan'); ?>
		<?php echo $form->textArea($model,'pilihan',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'susunan'); ?>
		<?php echo $form->textField($model,'susunan'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'id_jenis'); ?>
		<?php echo $form->textField($model,'id_jenis'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->