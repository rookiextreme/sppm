<?php
/* @var $this JenisSoalanController */
/* @var $model JenisSoalan */
?>

<h1>Senarai Soalan Penilaian</h1>
<?php 
if(Pengguna::model()->allowAdminAction())
    echo CHtml::button('+ Daftar Penilaian', array('class' => 'btn_print ui-corner-all', 'submit' => array('jenisSoalan/create'))); 
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'jenis-soalan-grid',
	'dataProvider'=>$model->search(),
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
		'tajuk_soalan',
		array(
			'class'=>'CButtonColumn',
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:20%;text-align:center'),
            'deleteConfirmation'=>"js:'Rekod dengan ID Jenis Soalan '+$(this).parent().parent().children(':first-child').text()+' akan dipadam! Teruskan?'",
            'template'=>'{daftar_penilaian} {update} {delete}',
            'buttons'=>array(
                'daftar_penilaian' => array(
                            'label'=>'Soalan Penilaian',
                            'url'=>'Yii::app()->createUrl("soalan/admin", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/document.png',
                        ),
                'update' => array(
                            'label'=>'Kemaskini',
                            'url'=>'Yii::app()->createUrl("jenisSoalan/update", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
                'delete' => array(
                            'label'=>'Padam',
                            'url'=>'Yii::app()->createUrl("jenisSoalan/updateisbin", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
			),
		),
	),
)); ?>
