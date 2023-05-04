<?php
/* @var $this JenisSoalanController */
/* @var $model JenisSoalan */
/* @var $form CActiveForm */
?>

<div class="form wide">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'jenis-soalan-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model, 'Ralat :'); ?>
    
	<div class="row">
		<?php echo $form->labelEx($model,'tajuk_soalan'); ?>
		<?php echo $form->textField($model,'tajuk_soalan',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ulasan'); ?>
		<?php echo $form->checkBox($model,'ulasan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cadangan'); ?>
		<?php echo $form->checkBox($model,'cadangan'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Daftar' : 'Kemaskini', array('class' => 'btn_general ui-corner-all')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->