<?php
/* @var $this SoalanController */
/* @var $model Soalan */
?>

<h1>Senarai Bahagian bagi <?php echo JenisSoalan::model()->getFieldByID($_GET['id'],'tajuk_soalan'); ?> </h1>
<form method="POST">
    <input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
    <?php echo CHtml::button('+ Daftar Bahagian', array('class' => 'btn_print ui-corner-all', 'submit' => array('soalan/create'))); ?>&nbsp;&nbsp;
    <?php echo CHtml::button('Senarai Penilaian', array('class' => 'btn_search ui-corner-all', 'submit' => array('jenisSoalan/admin'))); ?> &nbsp;&nbsp;
    <?php echo CHtml::button('Paparan', array('options' => array('target' => '_blank'), 'class' => 'btn_search ui-corner-all', 'submit' => array('survey/preview'))); ?> 
</form><br />

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'soalan-grid',
	'dataProvider'=>$model->sorting()->getSoalan($_GET['id'])->search(),
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
		'tajuk',
        array (
            'htmlOptions' => array('style' => 'width:25%;text-align:center'),
            'name' => 'allowed_peserta',
            'value' => 'Peserta::model()->getAllowedPeserta($data->allowed_peserta)',
        ),array (
            'htmlOptions' => array('style' => 'width:10%;text-align:center'),
            'name' => 'susunan',
        ),
		array(
			'class'=>'CButtonColumn',
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:20%;text-align:center'),
            'deleteConfirmation'=>"js:'Rekod dengan ID Soalan '+$(this).parent().parent().children(':first-child').text()+' akan dipadam! Teruskan?'",
            'template'=>'{daftar_soalan} {update} {delete}',
            'buttons'=>array(
                'daftar_soalan' => array(
                            'label'=>'Soalan Penilaian',
                            'url'=>'Yii::app()->createUrl("subSoalan/admin", array("id"=>$data["id"],"id_bahagian"=>'.$_GET['id'].'))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/document.png',
                        ),
                'update' => array(
                            'label'=>'Kemaskini',
                            'url'=>'Yii::app()->createUrl("soalan/update", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
                'delete' => array(
                            'label'=>'Padam',
                            'url'=>'Yii::app()->createUrl("soalan/updateisbin", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
                 ),    
		),
	),
)); ?>
