<?php
/* @var $this PembentanganController */
/* @var $model Pembentangan */
$majlis = Majlis::model()->findByPk($_GET['id']);
?>

<h1>
    Senarai Pembentangan bagi <?php echo $majlis->majlis; ?>
</h1>

<form method="POST">
    <input type="hidden" name="id" value="<?php echo $majlis->id?>" />
    <?php echo CHtml::button('+ Daftar Pembentangan', array('class' => 'btn_print ui-corner-all', 'submit' => array('pembentangan/create'))); ?>&nbsp;&nbsp;
    <?php echo CHtml::button('Senarai Majlis', array('class' => 'btn_search ui-corner-all', 'submit' => array('majlis/admin'))); ?> 
<br />
<?php $kategoriPeserta = Peserta::$kategori_peserta; ?>
<?php echo "<br /><p><h3>Kategori Peserta yang terlibat dengan pembentangan.</h3></p>"; ?>
<?php echo "<table class='ui-corner-all' style='margin-left:155px'>"; ?>
<?php foreach ($kategoriPeserta as $index => $value) { ?>
    <?php $checked=''; ?>
    <?php $exp = explode(",", $majlis->allowed_peserta_pembentangan); ?>
    <?php foreach ($exp as $e) { ?>
        <?php if($index == $e) {?>
            <?php $checked="checked"; ?>
        <?php } ?>
    <?php } ?>
    <?php if($index != Peserta::KATEGORI_TETAMU) { ?>
        <?php echo "<tr>"; ?>
        <?php echo "<td style='width: 5%'><input type='checkbox' $checked name='allowed_peserta[]' value='".$index."'></td><td>".$value."</td>"; ?>
        <?php echo "</tr>"; ?>
    <?php } ?>
<?php } ?>
<?php echo '</table>'; ?>
<input type="hidden" name="id_majlis" value="<?php echo $majlis->id?>" />
<?php echo CHtml::button('Set Peserta', array('class' => 'btn_print ui-corner-all', 'submit' => array('majlis/daftarKategoriPeserta'))); ?>
</form>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'pembentangan-grid',
	'dataProvider'=>$model->available()->getList($majlis->id)->search(),
    'summaryText'=>'{start} - {end} daripada {count}',
    'enableSorting' => false,
    'itemsCssClass' => 'table-class',
    'emptyText' => 'Tiada rekod ditemui.',
	'columns'=>array(
        array(
            'header' => Majlis::model()->getAttributeLabel("id"),
            'name' => 'id',
            'htmlOptions' => array('style' => 'width:10%;text-align:center'),
        ),
		'tajuk',
		array(
            'class'=>'CButtonColumn',
            'header'=>'Tindakan',
            'htmlOptions'=>array('style'=>'width:100px;text-align:center'),
            'deleteConfirmation'=>"js:'Rekod dengan ID Perbentangan '+$(this).parent().parent().children(':first-child').text()+' akan dipadam! Teruskan?'",
            'template'=>'{update} {delete}',
            'buttons'=>array(
                'update' => array(
                            'label'=>'Kemaskini',
                            'url'=>'Yii::app()->createUrl("pembentangan/update", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/edit.png',
                        ),
                'delete' => array(
                            'label'=>'Padam',
                            'url'=>'Yii::app()->createUrl("pembentangan/updateisbin", array("id"=>$data["id"]))',
                            'imageUrl'=>Yii::app()->request->baseUrl.'/images/cross.png',
                        ),
                 ),
        ),
	),
)); ?>
