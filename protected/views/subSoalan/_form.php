<?php
/* @var $this SubSoalanController */
/* @var $model SubSoalan */
/* @var $form CActiveForm */
?>

<div class="form wide">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'sub-soalan-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model, "Ralat : "); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'soalan'); ?>
		<?php echo $form->textField($model,'soalan',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'soalan'); ?>
	</div>

    <?php if($_GET['id_bahagian']){
        echo $form->hiddenField($model,'id_bahagian',array('value' => $_GET['id_bahagian'])); 
    }
    else if($_POST['id']){
        echo $form->hiddenField($model,'id_soalan',array('value' => $_POST['id'])); 
        echo $form->hiddenField($model,'id_bahagian',array('value' => $_POST['id_bahagian'])); 
    }?>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Daftar' : 'Kemaskini', array('class' => 'btn_general')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->