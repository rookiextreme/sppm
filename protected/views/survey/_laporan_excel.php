<?php
ob_start();

$filename = "Laporan_survey.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=$filename");
?>
<html>
        
<table width="60%" border="1">
   <?php
    $bil=1;
    $count=0;
    $alpha = 'B';
    foreach ($survey as $s) {
        $arr = array($s->markah, $s->pembentangan);
        $n = 0;
        foreach ($arr as $i => $a) {
            $exp = explode(',', $a);
            foreach ($exp as $item) {
                $scale = explode (':', $item);
                $tmp[$n][$s->id][$scale[0]] = $scale[1];
            }
            $n++;
        }
        if($count == 0) {
        echo '<tr width="100%"><th>Legend</th></tr>';
            foreach ($majlis->soalan as $soalan) {
                $num=1;
                foreach ($soalan->subsoalan as $sub) {
                    $headerLabel[$sub->id] = $alpha.$num;
					
				echo '<tr colspan="4">';
                    echo '<td width="1%">'.$alpha.$num.'</td>';
                    echo '<td width="99%">'.$sub->soalan.'</td></tr>';
                    $num++;
					
                }
                $alpha++;
            }
            echo '<tr style="background-color:#cccccc;">
                    <th width="5%">Bil</th>
                    <th width="10%">Gred</th>
                    <th width="10%">Jantina</th>
                    <th width="10%">Peserta</th>';
            foreach ($headerLabel as $index => $label) {
                    echo '<th width="5%">'.$label.'</th>';
            }
            for($i=1;$i<=$majlis->itemPembentangan;$i++) {
                echo '<th width="5%">'.$alpha.$i.'</th>';
            }
			
            echo'<th width="10%">Ulasan</th>';
            echo'<th width="10%">Cadangan</th>';
            echo '</tr>';
        }
        echo '<tr style="border-bottom: 1px solid #ddd">';
            echo '<td>'.$bil.'</td>';
            echo '<td>'.$s->peserta->gred.'</td>';
            echo '<td>'.Peserta::$jantinaArr[$s->peserta->jantina].'</td>';
            echo '<td>'.Peserta::$kategori_peserta[$s->peserta->kategori].'</td>';
            foreach ($majlis->soalan as $soalan) {
                foreach ($soalan->subsoalan as $sub) {
                    echo '<td>'.$tmp[0][$s->id][$sub->id].'</td>';
                }
            }
            foreach ($majlis->pembentangan as $p) {
                echo '<td>'.$tmp[1][$s->id][$p->id].'</td>';
            }
            echo '<td>'.$s->ulasan.'</td>';
            echo '<td>'.$s->cadangan.'</td>';
        echo '</tr>';
        $bil++;
        $count++;
    }
?>
</table>
    </html>
