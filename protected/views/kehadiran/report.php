<?php
/* @var $this KehadiranController */
/* @var $model Kehadiran */
?>
<br />
<table>
    <tr>
        <th rowspan="2">Bil</th>
        <th rowspan="2">Nama</th>
        <th rowspan="2">No. KP</th>
        <th rowspan="2">Organisasi</th>
        <th rowspan="2">Kategori</th>
        <th colspan="<?php echo count($jadual);?>">Majlis</th>
        <?php if(!empty($peserta)){
			echo '<th rowspan="2">Tempat Lawatan</th>';
		} else {
			echo '';
		}?>
    </tr>
    <tr>
        <?php
        foreach ($jadual as $j) {
            echo '<th>'.Yii::app()->dateFormatter->format("dd-MM-yyyy", strtotime($j->tarikh)).'</th>';
        }
        ?>
    </tr>
<?php
    $bil=0;
    foreach ($data as $d) {
	if($bil>0){
        $a[]=$d;
        echo '<tr>';
        echo '<td>'.$bil.'</td>';
        echo '<td>'.$d['nama'].'</td>';
        echo '<td>'.$d['nokp'].'</td>';
        echo '<td>'.$d['organisasi'].'</td>';
		echo '<td>'.Peserta::$kategori_peserta[$d['kategori']].'</td>';
        foreach ($jadual as $j) {
            echo '<td style="text-align:center;">'.Kehadiran::model()->statusKehadiran[$d[$j->id]['kehadiran']].'</font></td>';
        }
		if($d['tempat']){
			echo '<td>'.$d['tempat'].'</td>';
		}else {
			echo '';
			}
        echo '</tr>';
		}
        $bil++;
    }
	
?>
</table>