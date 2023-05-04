<?php
/* @var $this PesertaController */
/* @var $model Peserta */
?>

<h1>Senarai Peserta bagi <?php echo $majlis->majlis; ?></h1>

<?php if($error) { ?>
    <div class="flash-error">Pilih 1 hingga 3 pilihan kategori peserta sahaja.</div>
<?php } ?>
<form method="POST">
<?php $peserta = Peserta::model()->getKategoriPeserta($majlis->id); ?>
<?php if (!$peserta) { ?>
    <?php $kategoriPeserta = Peserta::$kategori_peserta;?>
    <?php echo "<br /><p><h3>Pilih Kategori Peserta yang terlibat.</h3> <i>(tidak melebihi 3 pilihan)</i></p>"; ?>
    <?php echo "<table class='ui-corner-all'>"; ?>
    <?php foreach ($kategoriPeserta as $index => $value) { ?>
        <?php echo "<tr>"; ?>
        <?php echo "<td style='width: 10%'><input type='checkbox' name='kat_peserta[]' value='".$index."'></td><td>".$value.'</td>'; ?>
        <?php echo "</tr>"; ?>
    <?php } ?>
    <?php echo '</table>'; ?>
    <input type="hidden" name="id_majlis" value="<?php echo $majlis->id?>" />
    <?php echo CHtml::button('Hantar', array('class' => 'btn_print ui-corner-all', 'submit' => array('peserta/daftarKategoriPeserta'))); ?>
<?php } else if ($majlis->jadual) { ?>
    <?php $legend = TRUE; ?>
    <?php echo CHtml::button('+ Peserta JKR', array('class' => 'btn_print ui-corner-all', 'submit' => array('peserta/daftar','id'=>$majlis->id))); ?>&nbsp;&nbsp;
    <?php echo CHtml::button('+ Peserta Bukan JKR', array('class' => 'btn_print ui-corner-all', 'submit' => array('peserta/create','id'=>$majlis->id))); ?>&nbsp;&nbsp;
<?php } else { ?>
    <?php $legend = FALSE; ?>
    <div class="flash-error">Daftar jadual terlebih dahulu sebelum peserta boleh didaftarkan.</div>
        <input type="hidden" name="id_majlis" value="<?php echo $majlis->id?>" />
        <?php echo CHtml::button('+ Daftar Jadual', array('class' => 'btn_print ui-corner-all', 'submit' => array('jadual/create'))); ?> 
<?php } ?>
    <?php echo ' '.CHtml::button('Senarai Majlis', array('class' => 'btn_search ui-corner-all', 'submit' => array('majlis/admin'))); ?><br /><br />
</form>
<?php
$count = 0;
$katcount = array();
$dropdownList = array();

if($peserta && $legend) {
    echo "<table class='legend ui-corner-all'>";
    foreach ($peserta as $kateogri => $label) {
        $count++;
        echo "<tr>";
        echo "<td style='width: 10%'><img src='".Yii::app()->request->baseUrl."/images/peserta_".$count.".png'></td>";
        echo "<td>Daftar {$label}</td>";
        echo "</tr>";
        $katcount[$kateogri] = $count;
        $dropdownList[$kateogri] = Peserta::$dropdownKategori[$kateogri];
        
    }
    
    echo '</table>';
?>
<br /><br /><br /><br />
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'peserta-grid',
	'dataProvider'=>$model->available()->getPeserta($majlis->id)->search(),
	'filter'=>$model,
    'summaryText'=>'{start} - {end} daripada {count}',
    'enableSorting' => false,
    'itemsCssClass' => 'table-class',
    'emptyText' => 'Tiada rekod ditemui.',
	'columns'=>array(
        array (
            'htmlOptions' => array('style' => 'width:7%;text-align:center'),
            'name' => 'id_pengguna',
        ),
        array (
            'htmlOptions' => array('style' => 'width:10%;text-align:center'),
            'name' => 'kategori',
            'header' => 'Kategori',
            'type' => 'raw',
            'value' => function($data,$row) use ($katcount) { // this is not an error
                            echo "<img src=".Yii::app()->request->baseUrl.'/images/peserta_'.$katcount[$data->kategori].'.png'.">";
                        },
            'filter' => CHtml::dropDownList("Peserta[kategori]", $model->kategori, $dropdownList,array('empty'=>'Semua')),
        ),
		'nama',
        array (
            'htmlOptions' => array('style' => 'width:18%;text-align:center'),
            'name' => 'nokp',
        ),
		'organisasi',
		'email',
       
        array (
            'htmlOptions' => array('style' => 'width:15%;text-align:center'),
            'name' => 'status',
            'header' => 'Status',
            'type' => 'raw',
            'filter' => CHtml::dropDownList("Peserta[status]", $model->status, Peserta::$dropdownKehadiran, array('empty'=>'Semua')),
            'value' => function($data,$row) use ($katcount) { // this is not an error
                            echo "<div align=left>".Peserta::model()->status_kehadiran[$data->status]."</div></br>";
//                            if (Peserta::model()->status_kehadiran[$data->status] == 2 ){
                            if ($data->status == 2 ){
                            echo "<div align=left class=small>Pengganti:".$data->nama_pengganti."</br>";
                            echo "Email:".$data->email_pengganti."</br>";
                            echo "Telefon:".$data->tel_pengganti."</div>";}
                        }),
	array(
            'class'=>'CButtonColumn',
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:100px;text-align:center'),
            'deleteConfirmation'=>"js:'Rekod dengan ID '+$(this).parent().parent().children(':first-child').text()+' dan NOKP '+$(this).parent().parent().children(':nth-child(3)').text()+' akan dipadam! Teruskan?'",
            'template'=>'{update} {delete}',
            'buttons'=>array(
                'update' => array(
                            'label'=>'Kemaskini',
                            'url'=>'Yii::app()->createUrl("peserta/update", array("id"=>$data["id_pengguna"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                        ),
                'delete' => array(
                            'label'=>'Padam',
                            'url'=>'Yii::app()->createUrl("peserta/updateisbin", array("id"=>$data["id_pengguna"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                        ),
                 ),       
        ),
	),
));
}
