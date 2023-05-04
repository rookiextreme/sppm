
.

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
        <th colspan="<?php echo count($jadual);?>">Majlis</th>
        <?php if(count($lawatan)) { ?><th colspan="<?php echo count($lawatan);?>">Lawatan Teknikal</th> <?php }?>
        <th rowspan="2">Tidak Hadir Berpengganti</th>
    </tr>
    <tr>
        <?php
        foreach ($jadual as $j) {
            echo '<th>'.Yii::app()->dateFormatter->format("dd-MM-yyyy", strtotime($j->tarikh)).'</th>';
        }
        ?>
         <?php
        foreach ($lawatan as $v) {
            echo '<th>'.$v->tempat.' ('.$count[$v->id].'/'.$v->limit_peserta.')</th>';
        }
        ?>
    </tr>
<?php

    $done = CHtml::image(Yii::app()->request->baseUrl.'/images/tick2.png');
    $delete = CHtml::image(Yii::app()->request->baseUrl.'/images/wrong.jpg');
    $bil=0;
    foreach ($data as $d) {
	if($bil>0){
        echo '<tr>';
        echo '<td>'.$bil.'</td>';
        echo '<td>'.$d['nama'].'</td>';
        echo '<td>'.$d['nokp'].'</td>';
        echo '<td>'.$d['organisasi'].'</td>';
        $checked=false;
        if($d['berpengganti']==1) {
            $checked="checked";
        }
        foreach ($jadual as $j) {
            if($d[$j->id]['kehadiran'] == Kehadiran::STATUS_HADIR) {
                $img = $done;
                $val = Kehadiran::STATUS_HADIR;
            } else if($d[$j->id]['kehadiran'] == Kehadiran::STATUS_TAK_HADIR) {
                $img = $delete;
                $val = Kehadiran::STATUS_TAK_HADIR;
            }
            if($checked == "checked") {
                echo '<td style="text-align:center;">-</td>';
            } else {
                echo '<td style="text-align:center;"><div class="updateall'.$d['id_pengguna'].'"><div id="update'.$d[$j->id]['id_kehadiran'].'">'.
                        CHtml::link($img,'',array(
                                                'class'=>'link kedatangan'.$d['id_pengguna'],
                                                'id_pengguna'=>$d['id_pengguna'],
                                                'id_kehadiran'=>$d[$j->id]['id_kehadiran'],
                                                'value'=>$val,
                                                'ganti'=>0,
                                    )).'</div></div></td>';
            }
        }
        foreach ($lawatan as $v) {
            
			if($count[$v->id] < $v->limit_peserta){
				if($d['id_lawatan']==$v->id) {
					$img = $done;
				} else if ($d['id_lawatan']<>$v->id){
					$img = $delete;
				}
				else {
					$img = CHtml::image(Yii::app()->request->baseUrl.'/images/stophand.png');;
				}
				if($checked == "checked") {
					echo '<td style="text-align:center;">-</td>';
				} else {
					echo '<td style="text-align:center;"><div class="updateall'.$d['id_pengguna'].'"><div id="updatelawatan'.$d['id_pengguna'].'">'.
							CHtml::link($img,'',array(
													'class'=>'link1 kedatangan'.$d['id_pengguna'],
													'id_pengguna'=>$d['id_pengguna'],
													'id_majlis'=>$d['id_majlis'],
													'id_lawatan'=>$v->id,
													'value'=>$val,
													'ganti'=>0,
										)).'</div></div></td>';
				}
			}
			else{
				if($d['id_lawatan']==$v->id) {
					$img = $done;
				} 
				else {
					$img = CHtml::image(Yii::app()->request->baseUrl.'/images/stophand.png');
				}
				
				echo '<td style="text-align:center;"><div class="updateall'.$d['id_pengguna'].'"><div id="updatelawatan'.$v->id.$d['id_pengguna'].'">'.
							CHtml::link($img,'').'</div></div></td>';
			}
		}
        echo '<td style="text-align:center;"><div id="ganti'.$d['id_pengguna'].'">'.
                    CHtml::CheckBox("berganti[{$d['id_pengguna']}]",$checked,array(
                                            'class'=>'link','ganti'=>1,
                                            'id_pengguna'=>$d['id_pengguna'],
                                            'id_majlis'=>$d['id_majlis'],
                                            'id_kehadiran'=>$d[$j->id]['id_kehadiran']
                                )).'</div></td>';
        echo '</tr>';
		}
        $bil++;
		
    }
?>
</table>