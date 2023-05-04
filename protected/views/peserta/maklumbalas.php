<?php
/* @var $this PesertaController */
/* @var $model Peserta */
?>
<br /><br />
<h1>Maklumbalas Kehadiran Peserta</h1>

<?php if (Yii::app()->user->hasFlash('maklumbalas')) { ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('maklumbalas'); ?>
    </div>
<?php } else  { ?>
    <h2>Sila sahkan kehadiran anda</h2>
    <?php echo $this->renderPartial('_form_maklumbalas', array('model'=>$model)); ?>
<?php } ?>