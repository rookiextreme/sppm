<?php
/* @var $this SoalanController */
/* @var $model Soalan */
/* @var $form CActiveForm */
?>

<div class="form wide">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'soalan-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model, 'Ralat : '); ?>

    <img src="images/pilihan.png" style="margin-left:160px;width:500px" />

	<div class="row">
		<?php echo $form->labelEx($model,'tajuk'); ?>
		<?php echo $form->textField($model,'tajuk',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'tajuk'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'allowed_peserta'); ?>
	</div>
    
	<?php $kategoriPeserta = Peserta::$kategori_peserta; ?>
    <?php echo "<table class='ui-corner-all' style='margin-left:155px'>"; ?>
    <?php foreach ($kategoriPeserta as $index => $value) { ?>
        <?php $checked=''; ?>
        <?php if(!$model->isNewRecord) { ?>
            <?php $exp = explode(",", $model->allowed_peserta); ?>
            <?php foreach ($exp as $e) { ?>
                <?php if($index == $e) {?>
                    <?php $checked="checked"; ?>
                <?php } ?>
            <?php } ?>
        <?php } ?>
        <?php if($index != Peserta::KATEGORI_TETAMU) { ?>
            <?php echo "<tr>"; ?>
            <?php echo "<td style='width: 5%'><input type='checkbox' $checked name='allowed_peserta[]' value='".$index."'></td><td>".$value."</td>"; ?>
            <?php echo "</tr>"; ?>
        <?php } ?>
    <?php } ?>
    <?php echo '</table>'; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'tajuk_pilihan'); ?>
		<?php echo $form->textField($model,'tajuk_pilihan',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'tajuk_pilihan'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'pilihan'); ?>
		<?php echo $form->textArea($model,'pilihan',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'pilihan'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'susunan'); ?>
		<?php echo $form->textField($model,'susunan'); ?>
		<?php echo $form->error($model,'susunan'); ?>
	</div>
    
    <?php if($_POST['id']) { ?>
        <?php echo $form->hiddenField($model,'id_jenis',array('value' => $_POST['id'])); ?>
    <?php }?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Daftar' : 'Kemaskini', array('class' => 'btn_general ui-corner-all')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->