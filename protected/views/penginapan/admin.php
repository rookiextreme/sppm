<?php
/* @var $this PenginapanController */
/* @var $model Penginapan */

?>

<h1>
    Senarai Penginapan bagi <?php echo Majlis::model()->getFieldByID($_GET['id'],'majlis'); ?>
</h1>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
    <?php echo CHtml::button('+ Daftar Penginapan', array('class' => 'btn_print ui-corner-all', 'submit' => array('penginapan/create'))); ?>
	&nbsp;&nbsp;
    <?php echo CHtml::button('Senarai Majlis', array('class' => 'btn_search ui-corner-all', 'submit' => array('majlis/admin'))); ?> 
</form><br />
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'penginapan-grid',
	'summaryText'=>'{start} - {end} daripada {count}',
    'itemsCssClass' => 'table-class',
    'enableSorting' => false,
	'dataProvider'=>$model->getList($_GET['id'])->search(),
	'columns'=>array(
		array (
            'htmlOptions' => array('style' => 'width:8%;text-align:center'),
            'name' => 'id',
        ),
        array (
            'htmlOptions' => array('style' => 'width:30%;'),
            'name' => 'penginapan',
        ),
		array(
            'class'=>'CButtonColumn',
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:20%;text-align:center'),
            'deleteConfirmation'=>"js:'Rekod dengan ID Penginapan '+$(this).parent().parent().children(':first-child').text()+' akan dipadam! Teruskan?'",
            'template'=>'{daftar_peserta} {update} {delete}',
            'buttons'=>array(
                'daftar_peserta' => array(
                            'label'=>'Tetapkan Penginapan Peserta',
                            'url'=>'Yii::app()->createUrl("peserta/penginapan", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/tambah-peserta.png',
                        ),
                'update' => array(
                            'label'=>'Kemaskini',
                            'url'=>'Yii::app()->createUrl("penginapan/update", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
                'delete' => array(
                            'label'=>'Padam',
                            'url'=>'Yii::app()->createUrl("penginapan/updateisbin", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
                 ), 
			),
	),
)); ?>
