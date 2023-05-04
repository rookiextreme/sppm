<?php
/* @var $this PenggunaController */
/* @var $model Pengguna */
?>

<h1>Senarai Penyelaras</h1>
<?php echo CHtml::button('+ Daftar Penyelaras', array('class' => 'btn_print ui-corner-all', 'submit' => array('pengguna/daftar'))); ?>

<?php 
if(!Pengguna::model()->allowAdminAction())
    $model->ownlist()->organizeronly();
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pengguna-grid',
	'dataProvider'=>$model->search(),
    'summaryText'=>'{start} - {end} daripada {count}',
    'enableSorting' => false,
    'itemsCssClass' => 'table-class',
    'emptyText' => 'Tiada rekod ditemui.',
//	'filter'=>$model,
	'columns'=>array(
        array (
            'htmlOptions' => array('style' => 'width:10%;text-align:center'),
            'name' => 'id',
        ),
		'nama',
        array (
            'htmlOptions' => array('style' => 'width:18%;text-align:center'),
            'name' => 'nokp',
        ),
		'organisasi',
		'email',
        array (
            'name' => 'peranan',
            'htmlOptions' => array('style' => 'width:15%;text-align:center'),
            'value' => 'Pengguna::model()->role[$data->peranan]',
        ),
		array(
            'class'=>'CButtonColumn',
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:100px;text-align:center'),
            'deleteConfirmation'=>"js:'Rekod dengan ID Majlis '+$(this).parent().parent().children(':first-child').text()+' akan dipadam! Teruskan?'",
            'template'=>'{view} {update} {delete}',  
            'buttons'=>array(
                'view' => array(
                            'label'=>'',
                            'url'=>'Yii::app()->createUrl("Pengguna/view", array("id"=>$data->id))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/search.png',
                        ),
                'update' => array(
                            'label'=>'Kemaskini',
                            'url'=>'Yii::app()->createUrl("Pengguna/update", array("id"=>$data->id))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                        ),
                'delete' => array(
                            'label'=>'Padam',
                            'url'=>'Yii::app()->createUrl("Pengguna/delete", array("id"=>$data->id))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                        ),
                 ),    
        ),
	),
)); ?>
