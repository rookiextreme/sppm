<?php
/* @var $this SurveyController */
/* @var $model Survey */
?>

<?php if (Yii::app()->user->hasFlash('SurveyWujud')) { ?>
    <div class="flash-error">
        <?php echo Yii::app()->user->getFlash('SurveyWujud'); ?>
    </div>
<?php } else if (Yii::app()->user->hasFlash('Survey')) { ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('Survey'); ?>
    </div>
<?php } else { ?>
    <?php echo $this->renderPartial('_form', array('model'=>$model,'Peserta'=>$Peserta, 'Majlis'=>$Majlis)); ?>
<?php } ?>