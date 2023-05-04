<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

    <div class="login-container">
        <?php echo CHtml::image(Yii::app()->request->baseUrl . '/images/bannerAduan.png') ?> 
        <br /><br />
        <div class="row">
            <div class="login-input-title"> ID Pengguna</div>
            <?php echo $form->textField($model,'username'); ?>
            <?php echo $form->error($model,'username'); ?>
        </div>

        <div class="row">
            <div class="login-input-title">Katalaluan</div>
            <?php echo $form->passwordField($model,'password'); ?>
            <?php echo $form->error($model,'password'); ?>
        </div>

        <div class="row rememberMe">
            <?php echo $form->checkBox($model,'rememberMe');?>Remember me
            <?php echo $form->error($model,'rememberMe'); ?>
        </div>

        <div class="row buttons">
            <?php echo CHtml::submitButton(' Daftar Masuk '); ?>
            <?php echo CHtml::button(' Kembali ',array('name' => 'btnBack','onclick'=>'js:history.go(-1);returnFalse;','class'=>'uibutton loading confirm'));?>
        </div>

    <?php $this->endWidget(); ?>
    </div>

</div><!-- form -->
