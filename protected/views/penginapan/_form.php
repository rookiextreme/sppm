<?php
/* @var $this PenginapanController */
/* @var $model Penginapan */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'penginapan-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Ruangan bertanda <span class="required">*</span> adalah wajib.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'penginapan'); ?>
		<?php echo $form->textField($model,'penginapan',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'penginapan'); ?>
	</div>
	<?php if($_POST['id']){
    echo $form->hiddenField($model,'id_majlis',array('value' => $_POST['id'])); 
    }?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->