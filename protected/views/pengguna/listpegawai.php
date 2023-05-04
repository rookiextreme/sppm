<?php
/* @var $this PenggunaController */
/* @var $model Pengguna */
?>

<?php 
$show = true;
if(!Pengguna::model()->allowAdminAction()) {
    $model->ownlist();
    $show = false;
}
?>

<?php if($show) { ?>
    <table class="legend ui-corner-all">
        <tr>
            <td style="width: 10%"><img src="<?php echo Yii::app()->request->baseUrl.'/images/peserta_2.png'; ?>"></td>
            <td>Daftar Sekretariat</td>
        </tr>
        <tr>
            <td><img src="<?php echo Yii::app()->request->baseUrl.'/images/penganjur.png'; ?>"></td>
            <td>Daftar Tuan Rumah</td>
        </tr>
        <tr>
            <td><img src="<?php echo Yii::app()->request->baseUrl.'/images/peserta_3.png'; ?>"></td>
            <td>Daftar Peranan Khas</td>
        </tr>
    </table>
<?php } ?>

<br />
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pengguna-grid',
	'dataProvider'=>$model->notinpengguna()->getSearch($string)->search(),
    'summaryText'=>'{start} - {end} daripada {count}',
    'enableSorting' => false,
    'itemsCssClass' => 'table-class',
    'emptyText' => 'Tiada rekod ditemui.',
	'columns'=>array(
        array(
                'header'=>'Bil',
                'htmlOptions' => array('style' => 'width:10%;text-align:center'),
                'value'=>'$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',       //  row is zero based
        ),
		'nama',
        array (
            'htmlOptions' => array('style' => 'width:18%;text-align:center'),
            'name' => 'nokp',
        ),
        array (
            'name' => 'kod_waran',
            'value' => 'LWaranPej::model()->getFullWaranName($data->kod_waran)',
        ),
		array(
            //  can use ButtonColumn extend from CButtonColumn - components/ButtonColumn.php (evaluateOptions)
            //  options for buttons
            // 'options'=>array('id'=>'uniqid()','class'=>'kertaskerja','evaluateOptions' => array('id'),),
            'class'=>'CButtonColumn', 
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:100px;text-align:center',),
            'template'=>'{tambah_sekretariat} {tambah_penganjur} {tambah_vip}',
            'buttons'=>array(
                'tambah_sekretariat' => array(
                            'label'=>'Daftar sekretariat',
                            'options'=>array('class'=>uniqid(),'live' => false,),
                            'imageUrl'=> Yii::app()->request->baseUrl.'/images/peserta_2.png',
                            'visible'=>'Pengguna::model()->allowAdminAction()',
                            'click' => 'js:function(evt){
                                    evt.preventDefault();
                                    var searchStr = document.getElementById("Pengguna_nama").value;
                                    var nama = $(this).parent().parent().children(":nth-child(2)").text();
                                    var nokp = $(this).parent().parent().children(":nth-child(3)").text();
                                    $.post("'.CController::createUrl('ajaxdaftarsekretariat').'",{nokp:nokp,searchStr:searchStr},function(data){
                                        if(data){
                                            document.getElementById("Pengguna_nama").value = searchStr;
                                            $("#update").html(data);
                                            $("html, body").animate({ scrollTop: 0 }, 0);
                                        }
                                    }) 
                                    return false;   
                                }',
                        ),
                'tambah_penganjur' => array(
                            'label'=>'Daftar tuan rumah',
                            'options'=>array('class'=>uniqid(),'live' => false,),
                            'imageUrl'=> Yii::app()->request->baseUrl.'/images/penganjur.png',
                            'click' => 'js:function(evt){
                                    evt.preventDefault();
                                    var searchStr = document.getElementById("Pengguna_nama").value;
                                    var nama = $(this).parent().parent().children(":nth-child(2)").text();
                                    var nokp = $(this).parent().parent().children(":nth-child(3)").text();
                                    $.post("'.CController::createUrl('ajaxdaftarpenganjur').'",{nokp:nokp,searchStr:searchStr},function(data){
                                        if(data){
                                            document.getElementById("Pengguna_nama").value = searchStr;
                                            $("#update").html(data);
                                            $("html, body").animate({ scrollTop: 0 }, 0);
                                        }
                                    }) 
                                    return false;   
                                }',
                        ),
                'tambah_vip' => array(
                            'label'=>'Daftar penaran khas',
                            'options'=>array('class'=>uniqid(),'live' => false,),
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/peserta_3.png',
                            'visible'=>'Pengguna::model()->allowAdminAction()',
                            'click' => 'function(){
                                    var searchStr = document.getElementById("Pengguna_nama").value;
                                    var nama = $(this).parent().parent().children(":nth-child(2)").text();
                                    var nokp = $(this).parent().parent().children(":nth-child(3)").text();
                                    $.post("'.CController::createUrl('ajaxdaftarvip').'",{nokp:nokp,searchStr:searchStr},function(data){
                                        if(data){
                                            document.getElementById("Pengguna_nama").value = searchStr;
                                            $("#update").html(data);
                                            $("html, body").animate({ scrollTop: 0 }, 0);
                                        }
                                        return false;
                                    })    
                                }',
                        ),
                 ),        
        ),
	),
)); ?>
