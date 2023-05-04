<?php
ob_start();
$filename = "Senarai_survey.xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: inline; filename=$filename");
?>
<html>
        <table>
            <br />
<table width="60%">
    <tr>
        <th width="5%">Bil</th>
        <th width="10%">Gred</th>
        <th width="10%">Jantina</th>
        <th width="10%">Peserta</th>
        <th width="5%">B1</th>
        <th width="5%">B2</th>
        <th width="5%">B3</th>
        <th width="5%">C1</th>
        <th width="5%">C2</th>
        <th width="5%">C3</th>
        <th width="5%">D1</th>
        <th width="5%">E1</th>
        <th width="5%">E2</th>
        <th width="5%">E3</th>
        
    </tr>
    
<?php
    
    $bil=1;
    foreach ($pengguna as $p) {
        if($p->status_survey == 1){
        echo '<tr style="text-align:center;">';
        echo '<td style="text-align:center;">'.$bil.'</td>';
        echo '<td style="text-align:center;">'.$p->gred.'</td>';
        echo '<td style="text-align:center;">'.Peserta::$jantinaArr[$p->jantina].'</td>';
        echo '<td style="text-align:center;">'.Peserta::$kakitanganArr[$p->kakitangan].'</td>';
      //echo '<td style="text-align:center;">';
        
      
        $c = new CDbCriteria();
        $c->condition = "id_pengguna = :id_pengguna";
        $c->params = array(":id_pengguna" => $p->id_pengguna);
        $survey = Survey::model()->findAll($c);
        foreach ($survey as $s){
        
        echo '<td style="text-align:center;">'.$s->soalan1.'</td>';
        echo '<td style="text-align:center;">'.$s->soalan2.'</td>';
        echo '<td style="text-align:center;">'.$s->soalan3.'</td>';
        echo '<td style="text-align:center;">'.$s->soalan4.'</td>';
        echo '<td style="text-align:center;">'.$s->soalan5.'</td>';
        echo '<td style="text-align:center;">'.$s->soalan6.'</td>';
        echo '<td style="text-align:center;">'.$s->soalan7.'</td>';
        echo '<td style="text-align:center;">'.$s->soalan8.'</td>';
        echo '<td style="text-align:center;">'.$s->soalan9.'</td>';
        echo '<td style="text-align:center;">'.$s->soalan10.'</td>';
        }
        echo '</td>';
        echo '</tr>';
        
        $bil++;
        
        }
        
    }
?>
</table>
    </html>
