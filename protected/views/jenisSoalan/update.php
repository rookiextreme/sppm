<?php
/* @var $this JenisSoalanController */
/* @var $model JenisSoalan */
?>

<h1>Kemaskini Penilaian <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>