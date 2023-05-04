<?php
/* @var $this MajlisController */
/* @var $model Majlis */
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
		<?php echo $form->label($model,'majlis'); ?>
		<?php echo $form->textField($model,'majlis',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'penganjur'); ?>
		<?php echo $form->textField($model,'penganjur',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'flag_aktif'); ?>
		<?php echo $form->textField($model,'flag_aktif'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'is_bin'); ?>
		<?php echo $form->textField($model,'is_bin'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'kemaskini_oleh'); ?>
		<?php echo $form->textField($model,'kemaskini_oleh'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tkh_kemaskini'); ?>
		<?php echo $form->textField($model,'tkh_kemaskini'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'daftar_oleh'); ?>
		<?php echo $form->textField($model,'daftar_oleh'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tkh_daftar'); ?>
		<?php echo $form->textField($model,'tkh_daftar'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->