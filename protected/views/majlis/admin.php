<?php
/* @var $this MajlisController */
/* @var $model Majlis */
?>

<h1>Senarai Majlis</h1>
<?php 
if(Pengguna::model()->allowAdminAction())
    echo CHtml::button('+ Daftar Majlis', array('class' => 'btn_print ui-corner-all', 'submit' => array('majlis/create'))); 
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'majlis-grid',
	'dataProvider'=>$model->available()->listByWaran()->search(),
    'summaryText'=>'{start} - {end} daripada {count}',
    'itemsCssClass' => 'table-class',
    'enableSorting' => false,
    'emptyText' => 'Tiada rekod ditemui.',
	'columns'=>array(
        array (
            'htmlOptions' => array('style' => 'width:8%;text-align:center'),
            'name' => 'id',
        ),
        array (
            'htmlOptions' => array('style' => 'width:30%;'),
            'name' => 'majlis',
        ),
        array (
            'htmlOptions' => array('style' => 'width:25%;text-align:center'),
            'name' => 'penganjur',
            'value' => 'LWaranPej::model()->getWaranName($data->penganjur)',
        ),
        array (
            'name' => 'flag_survey',
            'type' => 'raw',
            'htmlOptions' => array('style' => 'width:15%;text-align:center'),
            'value' => 'Utils::$listStatus[$data->flag_survey]." ".Survey::getSurveyStartStopLink($data->flag_survey,$data->id)',
            'visible' => Pengguna::model()->allowAdminAction(),
        ),
		array(
            'class'=>'CButtonColumn',
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:20%;text-align:center'),
            'deleteConfirmation'=>"js:'Rekod dengan ID Majlis '+$(this).parent().parent().children(':first-child').text()+' akan dipadam! Teruskan?'",
            'template'=>'{daftar_peserta} {daftar_pembentangan} {daftar_penginapan} {view} {update} {delete}',
            'buttons'=>array(
                'mula_survey' => array(
                            'label'=>'Mula Survey',
                            'visible'=>'($data->flag_survey == 0||is_null($data->flag_survey)) && Pengguna::model()->allowAdminAction()',
                            'url'=>'Yii::app()->createUrl("majlis/start", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/play.png',
                ),
                'tamat_survey' => array(
                            'label'=>'Tamat Survey',
                            'visible'=>'($data->flag_survey > 0)',
                            'url'=>'Yii::app()->createUrl("majlis/stop", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/stop.png',
                ),
                'daftar_peserta' => array(
                            'label'=>'Daftar Peserta',
                            'url'=>'Yii::app()->createUrl("peserta/pesertamajlis", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/tambah-peserta.png',
                        ),
                'daftar_pembentangan' => array(
                            'label'=>'Pembentangan',
                            'url'=>'Yii::app()->createUrl("pembentangan/admin", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/document.png',
                        ),
                'daftar_penginapan' => array(
                            'label'=>'Penginapan',
                            'url'=>'Yii::app()->createUrl("penginapan/admin", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/hotel.png',
                        ),
                'view' => array(
                            'label'=>'Senarai Jadual',
                            'url'=>'Yii::app()->createUrl("Majlis/view", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/calendar.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
                'update' => array(
                            'label'=>'Kemaskini',
                            'url'=>'Yii::app()->createUrl("Majlis/update", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
                'delete' => array(
                            'label'=>'Padam',
                            'url'=>'Yii::app()->createUrl("Majlis/updateisbin", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                            'visible'=> 'Pengguna::model()->allowAdminAction()',
                        ),
                 ),        
        ),
	),
));