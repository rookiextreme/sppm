<?php
/* @var $this PenggunaController */
/* @var $model Pengguna */
?>

<h1>Kemaskini Pengguna <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>