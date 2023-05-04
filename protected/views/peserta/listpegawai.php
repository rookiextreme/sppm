<?php
/* @var $this PesertaController */
/* @var $model Peserta */
?>

<?php
$peserta = Peserta::model()->getKategoriPeserta($id_majlis);
$arrTemplates = array('{tambah_1} ','{tambah_2} ','{tambah_3} ');
$count = 0;
$templates = '';
if($peserta) {
    echo "<table class='legend ui-corner-all'>";
    foreach ($peserta as $kateogri => $label) {
        $templates .= $arrTemplates[$count];
        $count++;
        echo "<tr>";
        echo "<td style='width: 10%'><img src='".Yii::app()->request->baseUrl."/images/peserta_".$count.".png'></td>";
        echo "<td>Daftar {$label}</td>";
        echo "</tr>";
        $button['tambah_'.$count] = array(
                                            'label'=>'Tambah '.$label,
                                            'options'=>array('class'=>uniqid(),'live' => false,),
                                            'imageUrl'=> Yii::app()->request->baseUrl.'/images/peserta_'.$count.'.png',
                                            'visible'=> 'Majlis::model()->checkParticipantExist('.$id_majlis.', $data->nokp)',
                                            'click' => 'js:function(evt){
                                                    evt.preventDefault();
                                                    var searchStr = document.getElementById("Peserta_nama").value;
                                                    var id = document.getElementById("Peserta_id").value;
                                                    var nama = $(this).parent().parent().children(":nth-child(2)").text();
                                                    var nokp = $(this).parent().parent().children(":nth-child(3)").text();
                                                    $.post("'.CController::createUrl('ajaxdaftarpeserta').'",{id:id,nokp:nokp,searchStr:searchStr,kategori:'.$kateogri.'},function(data){
                                                        if(data){
                                                            document.getElementById("Peserta_nama").value = searchStr;
                                                            $("#update").html(data);
                                                        }
                                                    }) 
                                                    return false;   
                                                }',
                                        );
    }
    echo '</table>';
}
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'peserta-grid',
	'dataProvider'=>$model->getSearch($string)->search(),
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
		array(
            //  can use ButtonColumn extend from CButtonColumn - components/ButtonColumn.php (evaluateOptions)
            //  options for buttons
            // 'options'=>array('id'=>'uniqid()','class'=>'kertaskerja','evaluateOptions' => array('id'),),
            'class'=>'CButtonColumn', 
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:100px;text-align:center',),
            'template'=>$templates,
            'buttons'=>$button,
        ),
	),
)); 