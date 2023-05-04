<?php
/* @var $this KeluargaController */
/* @var $model Keluarga */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'keluarga-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'id_peserta'); ?>
		<?php echo $form->textField($model,'id_peserta'); ?>
		<?php echo $form->error($model,'id_peserta'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nama'); ?>
		<?php echo $form->textField($model,'nama',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nama'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'umur'); ?>
		<?php echo $form->textField($model,'umur'); ?>
		<?php echo $form->error($model,'umur'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jantina'); ?>
		<?php echo $form->textField($model,'jantina',array('size'=>1,'maxlength'=>1)); ?>
		<?php echo $form->error($model,'jantina'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->