<?php
/* @var $this PembentanganController */
/* @var $model Pembentangan */
/* @var $form CActiveForm */
?>

<div class="form wide">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pembentangan-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model, 'Ralat :'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'tajuk'); ?>
		<?php echo $form->textField($model,'tajuk',array('size'=>60,'maxlength'=>255)); ?>
	</div>

    <?php if($_POST['id']){
        echo $form->hiddenField($model,'id_majlis',array('value' => $_POST['id'])); 
    }?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Daftar' : 'Kemaskini', array('class' => 'btn_general')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->