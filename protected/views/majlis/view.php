<?php
/* @var $this MajlisController */
/* @var $model Majlis */

?>

<h1>Senarai Jadual bagi <?php echo $model->majlis; ?></h1>

<form method="POST">
    <input type="hidden" name="id_majlis" value="<?php echo $model->id?>" />
    <?php echo CHtml::button('+ Daftar Jadual', array('class' => 'btn_print ui-corner-all', 'submit' => array('jadual/create'))); ?>&nbsp;&nbsp;
    <?php echo CHtml::button('Senarai Majlis', array('class' => 'btn_search ui-corner-all', 'submit' => array('majlis/admin'))); ?> 
</form>
<br />
<?php
$jadual = new CArrayDataProvider($model->getJadual(),
                    array('pagination'=>array(
                                'pageSize'=>Jadual::PERPAGE,
                            ),));
$this->renderPartial('_list_jadual',array(
            'model'=>$jadual,
        ));
?>

