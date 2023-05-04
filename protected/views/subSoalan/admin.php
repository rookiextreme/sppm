<?php
/* @var $this SubSoalanController */
/* @var $model SubSoalan */
?>

<h1>Senarai Soalan bagi <?php echo Soalan::model()->getFieldByID($_GET['id'],'tajuk'); ?></h1>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
    <input type="hidden" name="id_bahagian" value="<?php echo $_GET['id_bahagian']?>" />
    <?php echo CHtml::button('+ Daftar Soalan', array('class' => 'btn_print ui-corner-all', 'submit' => array('subSoalan/create'))); ?>&nbsp;&nbsp;
    <?php echo CHtml::button('Senarai Bahagian', array('class' => 'btn_search ui-corner-all', 'submit' => array('soalan/admin','id'=>$_GET['id_bahagian']))); ?> 
</form><br />

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'sub-soalan-grid',
	'dataProvider'=>$model->getSubSoalan($_GET['id'])->search(),
    'summaryText'=>'{start} - {end} daripada {count}',
    'itemsCssClass' => 'table-class',
    'enableSorting' => false,
    'emptyText' => 'Tiada rekod ditemui.',
	'filter'=>$model,
	'columns'=>array(
        array (
            'htmlOptions' => array('style' => 'width:8%;text-align:center'),
            'name' => 'id',
        ),
		'soalan',
		array(
			'class'=>'CButtonColumn',
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:20%;text-align:center'),
            'deleteConfirmation'=>"js:'Rekod dengan ID Sub Soalan '+$(this).parent().parent().children(':first-child').text()+' akan dipadam! Teruskan?'",
            'template'=>'{update} {delete}',
            'buttons'=>array(
                'update' => array(
                            'label'=>'Kemaskini',
                            'url'=>'Yii::app()->createUrl("subSoalan/update", array("id"=>$data["id"],"id_bahagian"=>'.$_GET['id_bahagian'].'))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
                'delete' => array(
                            'label'=>'Padam',
                            'url'=>'Yii::app()->createUrl("subSoalan/updateisbin", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
                 ),  
		),
	),
)); ?>
