<?php
/* @var $this JadualController */
/* @var $model Jadual */
/* @var $form CActiveForm */
?>

<div class="form wide">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'jadual-form',
	'enableAjaxValidation'=>false,
)); ?>

    <?php echo $form->errorSummary($model, 'Ralat :'); ?>

	<div class="row">
        <?php echo $form->labelEx($model,'tkh_mula'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'tkh_mula',
                'value' => $model->tkh_mula,
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'dd-mm-yy',
                    'changeYear' => true, // can change year
                    'changeMonth' => true,
                    'yearRange' => '1940:2039', // range of year    
                ),
                'htmlOptions'=>array('value'=>$_POST['Jadual']['tkh_mula']),
            ));
            ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tkh_tamat'); ?>
		<?php $form->widget('zii.widgets.jui.CJuiDatePicker', array(
                'model' => $model,
                'attribute' => 'tkh_tamat',
                // additional javascript options for the date picker plugin
                'options' => array(
                    'showAnim' => 'fold',
                    'dateFormat' => 'dd-mm-yy',
                    'changeYear' => true, // can change year
                    'changeMonth' => true,
                    'yearRange' => '1940:2039', // range of year    
                ),
                'htmlOptions'=>array('value'=>$_POST['Jadual']['tkh_tamat']),
            )); ?>
	</div>
    
    <?php echo $form->hiddenField($model,'id_majlis'); ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Daftar' : 'Kemaskini', array('class' => 'btn_general')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->