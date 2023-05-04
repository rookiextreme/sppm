<?php
/* @var $this KehadiranController */
/* @var $model Kehadiran */
?><br /><p align="right">
    <?php echo CHtml::link('Export to Excel',array('kehadiran/exportexcel','id'=> $id)); ?>
         </p>
<br />
<table>
    <tr>
        <th>Nama</th>
        <th>No. KP</th>
        <?php if(!empty($peserta)){
			echo '<th>Tempat Lawatan</th>';
		} else {
			echo '';
		}?>
    </tr>
<?php
    $bil=0;
    foreach ($data as $d) {
	if($bil>0){
        $a[]=$d;
		if($d['tempat']){
        echo '<tr>';
        echo '<td>'.$d['nama'].'</td>';
        echo '<td>'.$d['nokp'].'</td>';
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