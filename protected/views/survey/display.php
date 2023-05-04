<?php
/* @var $this SurveyController */
/* @var $model Survey */
/* @var $form CActiveForm */
?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array('id'=>'display-form','enableAjaxValidation'=>false,)); ?>
<?php echo $form->errorSummary($model); ?>
    <table bgcolor="#87CEFA" class="nobo surveyTable">
        <tr>
            <td colspan="7"  style="font-weight:bold">BORANG KAJI SELIDIK JKR MALAYSIA (<?php echo $modelM->majlis;?>)</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td colspan="7">Untuk kegunaan pejabat sahaja.</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td colspan="7">Bagi membolehkan penambahbaikan terhadap majlis-majlis JKR Malaysia, sukacita kiranya  dapat tuan memberi maklumbalas dan penilaian seperti di bawah. Terima kasih.</td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td width="5%"></td><td width="45%" ><div align="">Mesyuarat</div></td>
            <td colspan="5" style="font-weight:bold" width="50%"><div align="left"><?php echo $modelM->majlis;?></div></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="30%" ><div align="">Tarikh</div></td>
            <td colspan="5" style="font-weight:bold"><div align="left"><?php echo date('d/m/Y',strtotime($model->tkh_survey));?></div></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="30%" ><div align="">Tempat</div></td>
            <td colspan="5" style="font-weight:bold"><div align="left"><?php echo $modelM->tempat;?></div></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td colspan="7" width="40%" style="font-weight:bold">A. PROFIL PESERTA</td>
            <td style="font-weight:bold"><div align="center"></div></td>
        </tr>
        <tr>
            <td width="5%"></td><td width="30%" ><div align="">Gred</div></td>
            <td colspan="5" style="font-weight:bold"><div align="left"><?php echo $modelP->gred;?></div></td>
        </tr>
        <tr>
            <td width="5%"></td>
            <td width="30%" ><div align="">Jantina</div></td>
            <td colspan="5" style="font-weight:bold"><div align="left"><?php echo Peserta::$jantinaArr[$modelP->jantina];?></div></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td colspan="7" width="40%" style="font-weight:bold">ARAHAN</td>
        </tr>
        <tr>
            <td colspan="7" width="40%" >Sila pilih mengikut skala penilaian yang bersesuaian</td>
            <td style="font-weight:bold"></td>
        </tr>
        <tr>
            <td colspan="7">
                <?php
                $aplha = 'A';
                $count = 0;
                $model_jenis = JenisSoalan::model()->findByPk($modelM->jenis_soalan);
                echo '<table bgcolor="#87CEFA" class="surveyTable">';
                foreach ($model_jenis->soalan as $soalan) {
                    $opt = '';
                    $allowed_peserta = explode(',', $soalan->allowed_peserta);
                    if($soalan->allowed_peserta && in_array($modelP->kategori, $allowed_peserta)) {
                        echo '<tr><td colspan="2" style="font-weight:bold;width:60%;"><br />' . ++$aplha . '. ' . $soalan->tajuk . '</td>';
                        if($soalan->pilihan) {
                            $expPilihan = explode(',', $model->pilihan);
                            foreach ($expPilihan as $index => $value) {
                                $score = explode(':', $value);
                                $tmp[$score[0]] = $score[1]; 
                            }
                            $exp = explode(';', $soalan->pilihan);
                            foreach ($exp as $index => $value) {
                                if($tmp[$soalan->id] == $index && $model->pilihan) {
                                    $opt = $value;
                                }
                            }
                            echo '</tr><tr><td colspan="2" style="font-weight:bold;width:60%;">'.$soalan->tajuk_pilihan.' <select><option>'.$opt.'</option></select></td>';
                        }
                        if ($count == 0) {
                            for ($z = 1; $z < 6; $z++)
                                echo '<td style="font-weight:bold">' . $z . '</td>';
                        } else
                            echo '<td>&nbsp</td>';
                        echo '</tr>';
                        $model_soalan = Soalan::model()->findByPk($soalan->id);
                        $counter = 1;
                        foreach ($model_soalan->subsoalan as $sub) {
                            echo '<tr><td width="5%">' . $counter++ . '.</td><td>' . $sub->soalan . '</td>';
                                $nilai = 1;
                                $exp = explode(',', $model->markah);
                                foreach ($exp as $index => $value) {
                                    $score = explode(':', $value);
                                    $data[$score[0]] = $score[1]; 
                                }
                                for ($i = 0; $i < 5; $i++) {
                                    $checked = false;
                                    if ($data[$sub->id] == $nilai)
                                        $checked = true;
                                    echo '<td>' . CHtml::radioButton("Survey[markah][$sub->id]", $checked, array(
                                        'value' => $nilai,
                                        'uncheckValue' => null,
                                        'required' => TRUE,
                                        'disabled' => 'disabled',
                                    )) . '</td>';
                                    $nilai++;
                                }
                        }
                        echo '</tr>';
                        $count++;
                    }
                }
                $arrAllowedPeserta = explode(",", $modelM->allowed_peserta_pembentangan);
                if($modelM->pembentangan && in_array($Pengguna->kategori,$arrAllowedPeserta) && !empty($model->pembentangan)) {
                    $counter = 1;
                    echo '<tr><td colspan="2" style="font-weight:bold;width:60%;"><br />' . ++$aplha . '. PEMBENTANGAN KERTAS KERJA</td>';
                    foreach ($modelM->pembentangan as $p) {
                        echo '<tr><td width="5%">' . $counter++ . '.</td><td>' . $p->tajuk . '</td>';
                        $nilai = 1;
                        $data = null;
                        $exp = explode(',', $model->pembentangan);
                        foreach ($exp as $index => $value) {
                            $score = explode(':', $value);
                            $data[$score[0]] = $score[1]; 
                        }
                        for ($j = 0; $j < 5; $j++) {
                            $checked = false;
                            if ($data[$p->id] == $nilai)
                                $checked = true;
                            echo '<td>' . CHtml::radioButton("Survey[pembentangan][$p->id]", $checked, array(
                                'value' => $nilai,
                                'uncheckValue' => null,
                                'required' => TRUE,
                                'disabled' => 'disabled',
                            )) . '</td>';
                            $nilai++;
                        }
                    }
                }
                if($model_jenis->ulasan == 1) {
                    echo '<tr><td colspan="7" style="font-weight:bold"><br />' . ++$aplha . '. ULASAN</br>';
                    echo $form->textArea($model, 'ulasan', array('rows' => 6, 'cols' => 80, 'readOnly' => TRUE));
                    echo $form->error($model, 'ulasan');
                    echo '</td></tr>';
                }
                if($model_jenis->cadangan == 1) {
                    echo '<tr><td colspan="7" style="font-weight:bold"><br />' . ++$aplha . '. CADANGAN PENAMBAHBAIKAN</br>';
                    echo $form->textArea($model, 'cadangan', array('rows' => 6, 'cols' => 80, 'readOnly' => TRUE));
                    echo $form->error($model, 'cadangan');
                    echo '</td></tr>';
                }
                echo '</table>'; ?>
<?php $this->endWidget(); ?>
            </td>
        </tr>
    </table>
</div>