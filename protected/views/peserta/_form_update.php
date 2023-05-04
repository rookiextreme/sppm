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
    <br />
	<div class="row">
		<?php echo $form->labelEx($model,'nama'); ?>
		<?php echo $model->nama; ?>
	</div>
    <br />
	<div class="row">
		<?php echo $form->labelEx($model,'nokp'); ?>
		<?php echo $model->nokp; ?>
	</div>
    <br />
	<div class="row">
		<?php echo $form->labelEx($model,'organisasi'); ?>
		<?php echo $model->organisasi; ?>
	</div>
    <br />
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $model->email; ?>
	</div>
    <br />
    <div class="row">
		<?php echo $form->labelEx($model,'kategori'); ?>
		<?php echo $form->dropDownList($model,'kategori', Peserta::model()->getKategoriPeserta($model->id_majlis)); ?>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'id_penginapan'); ?>
        <?php echo $form->dropDownList($model,'id_penginapan',  CHtml::listData(Penginapan::model()->findAll(array('condition'=>'id_majlis = '.$model->id_majlis.'')),'id','penginapan')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Daftar' : 'Kemaskini', array('class' => 'btn_general')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
