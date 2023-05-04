<?php
/* @var $this PesertaController */
/* @var $model Peserta */
?>

<h1>Daftar Peserta bagi <?php echo $majlis->majlis; ?></h1><h3><i>(bukan kakitangan JKR)</i></h3>

<?php echo $this->renderPartial('_form', array('model'=>$model,'majlis'=>$majlis)); ?>