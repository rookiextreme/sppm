<?php
/* @var $this MajlisController */
/* @var $model Majlis */
/* @var $form CActiveForm */
?>

<div class="form wide">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'majlis-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model, 'Ralat :'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'majlis'); ?>
		<?php echo $form->textField($model,'majlis',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'penganjur'); ?>
        <?php 
            $cond = array(
                    'condition' => "substr(kod_waran_pej,5,8) = '00000000' AND substr(kod_waran_pej,1,2) <> '07' AND substr(kod_waran_pej,3,10) <> '0000000000' ORDER BY kod_waran_pej");
            ?>
        <?php echo $form->dropDownList($model,'penganjur',CHtml::listData(LWaranPej::model()->findAll($cond), 'kod_waran_pej', 'waran_pej')); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'tempat'); ?>
		<?php echo $form->textField($model,'tempat',array('size'=>60,'maxlength'=>255)); ?>
    </div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'jenis_soalan'); ?>
        <?php echo $form->dropDownList($model,'jenis_soalan',CHtml::listData(JenisSoalan::model()->findAll(), 'id', 'tajuk_soalan'), array('empty' => 'Sila Pilih')); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'pengesahan_kehadiran'); ?>
		<?php echo $form->checkBox($model,'pengesahan_kehadiran', array('checked' => ($model->isNewRecord ? TRUE:$model->pengesahan_kehadiran))); ?>
    </div>
    </br>
    <div class="row">
		<?php echo $form->labelEx($model,'kehadiran_keluarga'); ?>
		<?php echo $form->checkBox($model,'kehadiran_keluarga', array('checked' => ($model->isNewRecord ? TRUE:$model->kehadiran_keluarga))); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Daftar' : 'Kemaskini', array('class' => 'btn_general ui-corner-all')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->