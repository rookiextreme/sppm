<?php
/* @var $this PesertaController */
/* @var $model Peserta */
?>

<h1>Senarai Penyelaras</h1>
<?php echo CHtml::button('+ Daftar Penyelaras', array('class' => 'btn_print ui-corner-all', 'submit' => array('peserta/create'))); ?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'peserta-grid',
	'dataProvider'=>$model->search(),
    'summaryText'=>'{start} - {end} daripada {count}',
    'enableSorting' => false,
    'emptyText' => 'Tiada rekod ditemui.',
//	'filter'=>$model,
	'columns'=>array(
        array (
            'htmlOptions' => array('style' => 'width:10%;text-align:center'),
            'name' => 'id_pengguna',
        ),
		'nama',
        array (
            'htmlOptions' => array('style' => 'width:18%;text-align:center'),
            'name' => 'nokp',
        ),
		'organisasi',
		'email',
        array (
            'name' => 'kategori',
            'htmlOptions' => array('style' => 'width:15%;text-align:center'),
            'value' => 'Peserta::model()->kategori_peserta[$data->kategori]',
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
                            'url'=>'Yii::app()->createUrl("Majlis/view", array("nokp"=>$data["nokp"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/search.png',
                        ),
                'update' => array(
                            'label'=>'Kemaskini',
                            'url'=>'Yii::app()->createUrl("Majlis/update", array("nokp"=>$data["nokp"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                        ),
                'delete' => array(
                            'label'=>'Padam',
                            'url'=>'Yii::app()->createUrl("Majlis/delete", array("nokp"=>$data["nokp"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                        ),
                 ),      
        ),
	),
)); ?>
