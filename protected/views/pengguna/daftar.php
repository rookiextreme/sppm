<?php
/* @var $this PenggunaController */
/* @var $model Pengguna */
?>

<h1>Daftar Penyelaras</h1>
<br />
<div class="form wide">
    
<?php $form = $this->beginWidget('CActiveForm',array('id' => 'pengguna-form',)) ?>
    <?php echo "Nama / NoKP : ";?>
    <?php echo $form->textField($model, 'nama',array('size'=>50)) ?>
    <br />
    <div class="row">
        <?php $message = CJSON::encode($model); ?>
        <?php echo $form->error($model, 'nama') ?>
    </div>
    <?php echo CHtml::ajaxSubmitButton('Cari',array('ajaxloadform'),array('update' => '#update'),array('id'=>'ajaxlink-'.uniqid(),'class' => 'btn_print ui-corner-all'))?>
    <?php echo ' '.CHtml::link('Senarai Penyelaras', array('pengguna/admin'), array('class' => 'btn_search btn_link ui-corner-all')); ?>
<?php $this->endWidget() ?>
    
</div>
<div id="update"></div>