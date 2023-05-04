<?php
/* @var $this PesertaController */
/* @var $model Peserta */
?>

<h1>Daftar Peserta bagi <?php echo $majlis->majlis; ?></h1><h3><i>(kakitangan JKR)</i></h3>

<div class="form wide">
<?php $peserta = Peserta::model()->getKategoriPeserta($majlis->id); ?>
<?php if ($peserta) { ?>
<?php $form = $this->beginWidget('CActiveForm',array('id' => 'peserta-form',)) ?>
    <?php echo "Nama / NoKP : ";?>
    <?php echo $form->textField($model, 'nama',array('size'=>50)) ?>
    <?php echo $form->hiddenField($model, 'id',array('value'=>$majlis->id)) ?>
    <br />
    <div class="row">
        <?php $message = CJSON::encode($model); ?>
        <?php echo $form->error($model, 'nama') ?>
    </div>
    <?php echo CHtml::ajaxSubmitButton('Cari',array('ajaxloadform'),array('update' => '#update'),array('id'=>'ajaxlink-'.uniqid(),'class' => 'btn_print ui-corner-all'))?>
    <?php echo ' '.CHtml::link('Senarai Peserta', array('peserta/pesertamajlis','id'=>$majlis->id), array('class' => 'btn_search btn_link ui-corner-all')); ?>
<?php $this->endWidget() ?>
    
</div>
<div id="update"></div>
<?php } ?>