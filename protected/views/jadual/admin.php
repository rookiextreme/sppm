<?php
/* @var $this JadualController */
/* @var $model Jadual */?>
<h1>Senarai Jadual</h1>

<?php echo CHtml::button('+ Daftar Jadual', array('class' => 'btn_print', 'submit' => array('jadual/create'))); ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'jadual-grid',
	'dataProvider'=>$model->search(),
    'summaryText'=>'{start} - {end} daripada {count}',
    'enableSorting' => false,
    'emptyText' => 'Tiada rekod ditemui.',
//	'filter'=>$model,
	'columns'=>array(
        array (
            'htmlOptions' => array('style' => 'width:10%;text-align:center'),
            'name' => 'id',
        ),
        array (
            'htmlOptions' => array('style' => 'width:40%;'),
            'name' => 'tarikh',
            'value' => 'Yii::app()->dateFormatter->format("dd-MM-yyyy",strtotime($data->tarikh))',
        ),
        array (
            'htmlOptions' => array('style' => 'width:25%;text-align:center'),
            'name' => 'tempat',
        ),
//        array (
//            'name' => 'flag_aktif',
//            'htmlOptions' => array('style' => 'width:10%;text-align:center'),
//            'value' => 'Majlis::model()->listStatus[$data->flag_aktif]',
//        ),
		array(
            'class'=>'CButtonColumn',
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:100px;text-align:center'),
            'deleteConfirmation'=>"js:'Rekod dengan ID Jadual '+$(this).parent().parent().children(':first-child').text()+' akan dipadam! Teruskan?'",
            'buttons'=>array(
                'sah' => array(
                            'label'=>'Aduan Sah',
                            'url'=>'Yii::app()->createUrl("Aduan/sah", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/tick.png',
                        ),
                'view' => array(
                            'label'=>'Aduan Sah',
                            'url'=>'Yii::app()->createUrl("Jadual/view", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/search.png',
                        ),
                'update' => array(
                            'label'=>'Aduan Sah',
                            'url'=>'Yii::app()->createUrl("Jadual/update", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                        ),
                'delete' => array(
                            'label'=>'Aduan Sah',
                            'url'=>'Yii::app()->createUrl("Jadual/delete", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                        ),
                 ),
            'template'=>'{view} {update} {delete}'         
        ),
	),
)); ?>
