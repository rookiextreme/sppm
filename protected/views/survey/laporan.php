<?php
/* @var $this SurveyController */
/* @var $model Survey */
?>

<h1>Laporan Penilaian Peserta</h1>

<div class="form wide">
    
<?php $form = $this->beginWidget('CActiveForm',array('id' => 'Survey-form',)) ?>
    <?php echo "Majlis : ";?>
    <?php echo $form->dropDownList(Majlis::model(),'id', CHtml::listData(Majlis::model()->getMajlisDropdownList(), 'id', 'majlis')); ?>
    <?php echo CHtml::ajaxSubmitButton('Cari',array('ajaxLaporanPenilaianPeserta'),array('update' => '#update'),array('class' => 'btn_search ui-corner-all'))?>
    <?php $this->endWidget() ?>
    
</div>
<div id="update"></div>
