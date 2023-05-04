<?php
/* @var $this PenggantiController */
/* @var $model Pengganti */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pengganti-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

        <div class="row">
                <?php echo $form->labelEx($model,'status');?>
                <?php echo $form->radioButtonList($model,'status',array('1'=>"Hadir",'0'=>"Tidak Hadir",'2'=>"Tidak Hadir Berpengganti")); ?>
                <?php echo $form->error($model,'status'); ?>
        </div>
        
	<div class="row">
		<?php echo $form->labelEx($model,'nama_pengganti'); ?>
		<?php echo $form->textField($model,'nama_pengganti',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nama_pengganti'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email_pengganti'); ?>
		<?php echo $form->textField($model,'email_pengganti',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email_pengganti'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'telefon_pengganti'); ?>
		<?php echo $form->textField($model,'telefon_pengganti',array('size'=>50,'maxlength'=>50)); ?>
		<?php echo $form->error($model,'telefon_pengganti'); ?>
	</div>

<!--	<div class="row">
		<?php // echo $form->labelEx($model,'id_peserta_asal'); ?>
		<?php // echo $form->textField($model,'id_peserta_asal'); ?>
		<?php // echo $form->error($model,'id_peserta_asal'); ?>
	</div>-->

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->