<?php
ob_start();

$filename = "Senarai_peserta_lawatan.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=$filename");
?>
<html>
   <table border="1">
    <tr bgcolor="#A4A4A4">
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
        echo '<tr bgcolor="#E0F8F7">';
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
    </html>
