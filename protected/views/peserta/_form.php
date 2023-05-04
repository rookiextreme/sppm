<?php
/* @var $this PesertaController */
/* @var $model Peserta */
/* @var $form CActiveForm */

$arrJabatan = CHtml::listData(Jabatan::model()->getAgenciesList(), 'kod', 'keterangankod');
$arrJabatan[Jabatan::LAIN_LAIN] = "Lain-lain"; // add lain-lain to dropdownlist
?>

<div class="form wide">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'peserta-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model, 'Ralat :'); ?>
    
	<div class="row">
		<?php echo $form->labelEx($model,'nama'); ?>
		<?php echo $form->textField($model,'nama',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nokp'); ?>
		<?php echo $form->textField($model,'nokp',array('size'=>12,'maxlength'=>12)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'organisasi'); ?>
		<?php echo $form->textArea($model,'organisasi',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'kod_jabatan'); ?>
        <?php echo $form->dropDownList($model,'kod_jabatan',$arrJabatan); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel_pej'); ?>
		<?php echo $form->textField($model,'tel_pej',array('size'=>15,'maxlength'=>15)); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'gred'); ?>
		<?php echo $form->textField($model,'gred',array('size'=>30,'maxlength'=>5)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'jantina'); ?>
        	<?php echo $form->dropDownList($model,'jantina', Peserta::$jantinaArr); ?>
	</div>
    
    	<div class="row">
		<?php echo $form->labelEx($model,'kategori'); ?>
		<?php echo $form->dropDownList($model,'kategori', Peserta::model()->getKategoriPeserta($majlis->id)); ?>
	</div>
    
    <?php echo $form->hiddenField($model, 'id_majlis',array('value'=>$majlis->id)) ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Daftar' : 'Kemaskini', array('class' => 'btn_general')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
