<?php
/* @var $this KehadiranController */
/* @var $model Kehadiran */
?>

<h1>Laporan Peserta</h1>

<div class="form wide">
    
<?php $form = $this->beginWidget('CActiveForm',array('id' => 'kehadiran-form',)) ?>
    <?php echo "Majlis : ";?>
    <?php echo $form->dropDownList($model,'id', CHtml::listData(Majlis::model()->getMajlisDropdownList(), 'id', 'majlis')); ?>
    <?php echo CHtml::ajaxSubmitButton('Cari',array('ajaxreportkehadiran'),array('update' => '#update'),array('class' => 'btn_search ui-corner-all'))?>
<?php $this->endWidget() ?>
    
</div>
<div id="update"></div>