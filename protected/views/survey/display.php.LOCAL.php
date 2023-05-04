<?php
/* @var $this SurveyController */
/* @var $model Survey */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array('id'=>'display-form','enableAjaxValidation'=>false,)); ?>
    <!--<p class="note">Fields with <span class="required">*</span> are required.</p>-->
<?php echo $form->errorSummary($model); ?>
<?php  
     echo '<table bgcolor="#87CEFA" class="nobo">'; 
////     echo '<tr><td></td></tr></table>';
//     echo '<table>';
     echo '<tr><td colspan="4"  style="font-weight:bold">BORANG PENILAIAN MESYUARAT PEGAWAI KANAN JKR MALAYSIA 2015</td>';
     echo '<tr><td></td></tr>';
     echo '<tr><td colspan="4">Untuk kegunaan pejabat sahaja.</td>';
     echo '<tr><td></td></tr>';
     echo '<tr><td colspan="4">Bagi membolehkan penambahbaikan terhadap mesyuarat pegawai kanan JKR Malaysia, sukacita kiranya  dapat tuan memberi maklumbalas dan penilaian seperti di bawah. Terima kasih.</td>';
     
     echo '<tr><td width="5%"></td><td width="45%" ><div align="">Mesyuarat</div></td><td style="font-weight:bold" width="50%"><div align="left" colspan="2">'.$modelM->majlis.'</div></td>';
     echo '<tr><td width="5%"></td><td width="30%" ><div align="">Tarikh</div></td><td style="font-weight:bold"><div align="left" colspan="2">'.date('d/m/Y',strtotime($model->tkh_survey)).'</div></td>';
     echo '<tr><td width="5%"></td><td width="30%" ><div align="">Tempat</div></td><td style="font-weight:bold"><div align="left colspan="2">'.$modelM->tempat.'</div></td>';
     echo '<tr><td></td></tr>';
     
     echo '<tr><td colspan="3" width="40%" style="font-weight:bold">A. PROFIL PESERTA</td><td style="font-weight:bold"><div align="center"></div></td>';
     echo '<tr><td width="5%"></td><td width="30%" ><div align="">Gred</div></td><td style="font-weight:bold"><div align="left">'.$modelP->gred.'</div></td>';
     echo '<tr><td width="5%"></td><td width="30%" ><div align="">Jantina</div></td><td style="font-weight:bold"><div align="left">'. Peserta::$jantinaArr[$modelP->jantina].'</div></td>';
     echo '<tr><td></td></tr>';
     
     echo '<tr><td colspan="4" width="40%" style="font-weight:bold">ARAHAN</td>';
     echo '<tr><td colspan="4" width="40%" >Sila pilih mengikut skala penilaian yang bersesuaian</td><td style="font-weight:bold"></td>';
     
    $c = new CDbCriteria();
    $c->condition = "id_majlis = :id_majlis";
    $c->order = "id ASC";
    $c->params = array(":id_majlis" => $_GET['id_majlis']);
    $list_pembentangan = CHtml::listData(Pembentangan::model()->findAll($c),'id','tajuk');

    $append_rb = array(
        'F. PEMBENTANGAN KERTAS KERJA' =>
            array(
                'soalan11' => $list_pembentangan,             
         ),);
    
    
    if($modelP->kategori==Peserta::KATEGORI_KERTASKERJA)
        $rb_name = array_merge(Survey::model()->rb_name, $append_rb);
    else
        $rb_name = Survey::model()->rb_name;
//    $rb_name = array_merge(Survey::model()->rb_name, $append_rb);
    foreach ($rb_name as $kategori => $set) {
        echo '<tr><td colspan="3" style="font-weight:bold">'.$kategori;
        echo '</td></tr>';
        $counter = 1;
        foreach ($set as $soalan => $title) {
            if(is_array($title) && $modelP->kategori==Peserta::KATEGORI_KERTASKERJA){
                foreach ($title as $id => $t) {
                    echo '<tr><td width="5%">'.$counter.'</td><td>'.$t.'</td><td align="right" width="20%">';
                    $counter++;
                    $nilai = 1;
                    $exp = explode(',', $model->$soalan);
                    foreach ($exp as $index => $value) {
                        $score = explode(':', $value);
                        $data[$score[0]] = $score[1]; 
                    }
                    
                    for($j=0;$j<5;$j++) {
                        $checked = false;
                        if ($data[$id] == $nilai)
                            $checked = true;
                        
                       
                        echo CHtml::radioButton("Survey[$soalan][$id]", $checked, array(
                                'value' => $nilai,
                                'uncheckValue'=>null,
                                'required' => TRUE,
                            ));
                        $nilai++;
                    }
                }
            } else {
                echo '<tr><td width="5%">'.$counter.'</td><td>'.$title.'</td><td align="right" width="20%">';
                $counter++;
                $nilai = 1;
                for($i=0;$i<5;$i++) {
                    $checked = false;
                    if ($model->$soalan == $nilai)
                        $checked = true;
                    echo "          ";
                    echo CHtml::radioButton("Survey[$soalan]", $checked, array(
                            'value' => $nilai,
                            'uncheckValue'=>null,
                            'required' => TRUE,
                        ));
                    $nilai++;
                }
            }
            echo '</td></tr>';
        }
    }
     echo '<tr><td colspan="4" style="font-weight:bold">G. ULASAN</br>';
     echo $form->textArea($model,'ulasan',array('rows' => 6,'cols' => 80,'value'=>$model->ulasan)); 
     echo $form->error($model,'ulasan'); 
     echo '</td></tr>';
     
     echo '<tr><td colspan="4" style="font-weight:bold">H. CADANGAN PENAMBAHBAIKAN</br>';
     echo $form->textArea($model,'cadangan',array('rows'=>6,'cols' => 80,'value'=>$model->cadangan)); 
     echo $form->error($model,'cadangan'); 
     echo '<tr><td colspan="2">';
     echo '</table>';
    
    ?>
<?php $this->endWidget(); ?>
 
</div>