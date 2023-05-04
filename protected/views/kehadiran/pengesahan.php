<?php
/* @var $this KehadiranController */
/* @var $model Kehadiran */
?>

<h1>Pengesahan Kehadiran Peserta</h1>

<div class="form wide">

<?php $form = $this->beginWidget('CActiveForm',array('id' => 'kehadiran-form',)) ?>
    <table>
        <tr>
            <td style="width: 20%">Majlis :</td>
            <td><?php echo $form->dropDownList($model,'id', CHtml::listData(Majlis::model()->getMajlisDropdownList(), 'id', 'majlis')); ?></td>
        </tr>
        <tr>
            <td>Nama / NoKP :</td>
            <td><?php echo CHtml::textfield('nama',$model,array('size'=>60,'maxlength'=>200));?></td>
        </tr>
    </table>
    <?php echo CHtml::ajaxSubmitButton('Cari',array('ajaxsenaraipeserta'),array('update' => '#update'),array('id'=>'ajaxbtnkehadiran','class' => 'btn_search ui-corner-all'))?>
<?php $this->endWidget() ?>
    
</div>
<div id="update"></div>

<?php
Yii::app()->clientScript->registerScript('link', "
    $('.link').live('click',function(){
        var id_pengguna = $(this).attr('id_pengguna');
        var id_majlis = $(this).attr('id_majlis');
        var id_kehadiran = $(this).attr('id_kehadiran');
        var id_lawatan = $(this).attr('id_lawatan');
        var ganti = $(this).attr('ganti');
        var val = $(this).attr('value');
        var checkval = $(this).attr('checked');
        var data = 'idpengguna='+id_pengguna+'&idkehadiran='+id_kehadiran+'&ganti='+ganti+'&val='+val+'&checkval='+checkval+'&idmajlis='+id_majlis+'&idlawatan='+id_lawatan;
        $.ajax({
            type : 'POST',
            url : '".CController::createUrl('kehadiran/ajaxattendanceupdate')."',
            data : data,
            success : function(ret){
                if(ganti == 0){
                    $('#update'+id_kehadiran).html(ret);
                } else if(ganti == 1){
                    $('.updateall'+id_pengguna).html(ret);
                    if(typeof checkval === 'undefined') {
                        $('#ajaxbtnkehadiran').trigger('click'); 
                    }
                }
            }
        });
    });
	
	$('.link1').live('click',function(){
        var id_pengguna = $(this).attr('id_pengguna');
        var id_majlis = $(this).attr('id_majlis');
        var id_kehadiran = $(this).attr('id_kehadiran');
        var id_lawatan = $(this).attr('id_lawatan');
        var ganti = $(this).attr('ganti');
        var val = $(this).attr('value');
        var checkval = $(this).attr('checked');
        var data = 'idpengguna='+id_pengguna+'&idkehadiran='+id_kehadiran+'&ganti='+ganti+'&val='+val+'&checkval='+checkval+'&idmajlis='+id_majlis+'&idlawatan='+id_lawatan;
        $.ajax({
            type : 'POST',
            url : '".CController::createUrl('kehadiran/ajaxattendanceupdate2')."',
            data : data,
            success : function(ret){
					$('#ajaxbtnkehadiran').trigger('click');
                
            }
        });
    });
	
");


//Yii::app()->clientScript->registerScript('link', "
//    $('.link').live('click',function(){
//        var id_pengguna = $(this).attr('id_pengguna');
//        var id_majlis = $(this).attr('id_majlis');
//        var id_kehadiran = $(this).attr('id_kehadiran');
//        var ganti = $(this).attr('ganti');
//        var val = $(this).attr('value');
//        var checkval = $(this).attr('checked');
//        var data = 'idpengguna='+id_pengguna+'&idkehadiran='+id_kehadiran+'&ganti='+ganti+'&val='+val+'&checkval='+checkval+'&idmajlis='+id_majlis;
//        $.ajax({
//            type : 'POST',
//            url : '".CController::createUrl('kehadiran/ajaxattendanceupdate')."',
//            data : data,
//            success : function(ret){
//                if(ganti == 0){
//                    $('#update'+id_kehadiran).html(ret);
//                } else if(ganti == 1){
//                    $('.updateall'+id_pengguna).html(ret);
//                    if(typeof checkval === 'undefined') {
//                        $('#ajaxbtnkehadiran').trigger('click'); 
//                    }
//                }
//            }
//        });
//    });
//");