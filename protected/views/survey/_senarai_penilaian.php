<?php
/* @var $this KehadiranController */
/* @var $model Kehadiran */
?>
<br />
<table >
    <tr>
        <th width="3%">Bil</th>
        <th width="20%">Gred</th>
        <th width="20%">Jantina</th>
        <th width="20%">Peserta</th>
        <th width="20%">Tindakan</th>
    </tr>
    
<?php
    $bil=1;
    foreach ($pengguna as $p) {
        if($p->status_survey == 1){
        echo '<tr style="text-align:center;">';
        echo '<td style="text-align:center;">'.$bil.'</td>';
        echo '<td style="text-align:center;">'.$p->gred.'</td>';
        echo '<td style="text-align:center;">'.Peserta::$jantinaArr[$p->jantina].'</td>';
        echo '<td style="text-align:center;">'.Peserta::$kategori_peserta[$p->kategori].'</td>';
        echo '<td style="text-align:center;" >';
        
       
        $c = new CDbCriteria();
        $c->condition = "id_pengguna = :id_pengguna";
        $c->params = array(":id_pengguna" => $p->id_pengguna);
        $survey = Survey::model()->findAll($c);
        foreach ($survey as $s){
         
        echo CHtml::link('View',array('survey/display','id'=>$s->id));
                  
        }
        echo '</td>';
        echo '</tr>';
        $bil++;
        
        }
    }
?>
</table>