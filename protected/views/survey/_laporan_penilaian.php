<?php
/* @var $this SuveyController */
/* @var $model Survey */
?>
<br /><p align="right">
    <?php echo CHtml::link('Export to Excel',array('survey/laporanexcel','id'=> $majlis->id)); ?>
         </p>
<table width="60%">
   
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
            foreach ($majlis->soalan as $soalan) {
                $num=1;
                foreach ($soalan->subsoalan as $sub) {
                    $headerLabel[$sub->id] = $alpha.$num;
                    $num++;
                }
                $alpha++;
            }
            echo '<tr>
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
            echo '</tr>';
        }
        echo '<tr>';
            echo '<td>'.$bil.'</td>';
            echo '<td>'.$s->peserta->gred.'</td>';
            echo '<td>'.Peserta::$jantinaArr[$s->peserta->jantina].'</td>';
            echo '<td style="font-size:10pt">'.Peserta::$kategori_peserta[$s->peserta->kategori].'</td>';
            foreach ($majlis->soalan as $soalan) {
                foreach ($soalan->subsoalan as $sub) {
                    echo '<td>'.$tmp[0][$s->id][$sub->id].'</td>';
                }
            }
            foreach ($majlis->pembentangan as $p) {
                echo '<td>'.$tmp[1][$s->id][$p->id].'</td>';
            }
        echo '</tr>';
        $bil++;
        $count++;
    }
?>
</table>