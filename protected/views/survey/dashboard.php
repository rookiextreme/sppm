<?php
/* @var $this SurveyController */
/* @var $model Survey */
?>

<div class="form wide">
    
<?php $form = $this->beginWidget('CActiveForm',array('id' => 'dashboard-form',)) ?>
    <?php echo "Majlis : ";?>
    <?php echo $form->dropDownList($model,'id',CHtml::listData(Majlis::model()->getMajlisDropdownList(), 'id', 'majlis')); ?>
    <?php echo CHtml::ajaxSubmitButton('Jana',array('ajaxloadform'),array('update' => '#update'),array('id'=>'ajaxlinkdashboard','class' => 'btn_print ui-corner-all'))?>
<?php $this->endWidget() ?>
    
</div>
<br /><br />
<div id="update"></div>
<?php
Yii::app()->clientScript->registerScript('link', "
    $('#ajaxlinkdashboard').trigger('click'); 
");
