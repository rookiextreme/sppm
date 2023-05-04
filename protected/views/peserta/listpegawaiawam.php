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
		array (
            'htmlOptions' => array('style' => 'width:18%;text-align:center'),
            'name' => 'kerusi',
        ),
	),
));
