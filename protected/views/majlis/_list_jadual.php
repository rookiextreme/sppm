<?php
/* @var $this MylatJadualController */
/* @var $model MylatJadual */
?>

<?php 
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'jadual-grid',
	'dataProvider' => $model,
    'summaryText'=>'{start} - {end} daripada {count}',
    'itemsCssClass' => 'table-class',
    'emptyText' => 'Tiada rekod ditemui.',
	'columns' => array(
        array(
            'header' => Jadual::model()->getAttributeLabel("id"),
            'name' => 'id',
            'htmlOptions' => array('style' => 'text-align:center'),
        ),
        array (
            'header' => Jadual::model()->getAttributeLabel("tarikh"),
            'name' => 'tarikh',
            'htmlOptions' => array('style' => 'text-align:center'),
        ),
        array(
            'class'=>'CButtonColumn',
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:30%;text-align:center'),
            'deleteConfirmation'=>"js:'Rekod dengan ID Jadual '+$(this).parent().parent().children(':first-child').text()+' akan dipadam! Teruskan?'",
            'template'=>'{delete}',
            'buttons'=>array(
                'view' => array(
                            'label'=>'Senarai jadual',
                            'url'=>'Yii::app()->createUrl("jadual/view", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/search.png',
                        ),
                'update' => array(
                            'label'=>'Kemaskini jadual',
                            'url'=>'Yii::app()->createUrl("jadual/update", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                        ),
                'delete' => array(
                            'label'=>'Padam jadual',
                            'url'=>'Yii::app()->createUrl("jadual/updateisbin", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                        ),
                 ),       
        ),),    
));?>			
