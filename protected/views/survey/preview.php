<?php
/* @var $this SurveyController */
/* @var $model Survey */
/* @var $form CActiveForm */
?>
<br /><br />
<?php echo CHtml::button('<< Kembali', array('class' => 'btn_print ui-corner-all', 'onclick' => "history.go(-1)")); ?>
<h1><center>PAPARAN SOALAN PENILAIAN</center></h1>
<table bgcolor="#87CEFA" class="nobo surveyTable">
    <tr>
        <td colspan="3">
            <p align="center"><strong>BORANG KAJI SELIDIK JKR MALAYSIA</strong></p>
            <p align="center"><strong><u>Untuk kegunaan pejabat sahaja.</u></strong></p>
            <p>Bagi membolehkan penambahbaikan terhadap majlis-majlis JKR Malaysia, sukacita kiranya  dapat tuan memberi maklumbalas dan penilaian seperti di bawah. Terima kasih.</p>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <table width="50%" align="center">
                <tr>
                    <td width="15%"><p><strong>MESYUARAT</strong></p></td>
                    <td width="1%"><p><strong>: </strong></p></td>
                    <td width="539"><p></p></td>
                </tr>
                <tr>
                    <td width="130"><p><strong>TARIKH</strong></p></td>
                    <td width=""><p><strong>: </strong></p></td>
                    <td width="539"><p></p></td>
                </tr>
                <tr>
                    <td width="130" height="21"><p><strong>TEMPAT</strong></p></td>
                    <td width=""><p><strong>: </strong></p></td>
                    <td width="539"><p></p></td>
                </tr>
                <tr >
                    <td width="" colspan="3"><strong>A. PROFIL PESERTA</strong></td>
                </tr>
                <tr>
                    <td width="15%"><p><strong>GRED </strong></p></td>
                    <td width="1%"><p>:</p></td>
                    <td width="539"><p></p></td>
                </tr>
                <tr>
                    <td width="130"><p><strong>JANTINA</strong></p></td>
                    <td width="539"><p>:</p></td>
                    <td width="539"><p></p></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <p><strong>ARAHAN</strong></p>
            <p>Sila pilih mengikut skala penilaian yang bersesuaian</p></br>
            <div align="center">
                <img src="./images/scale.jpg" width="636" height="115" />
            </div><br />
        </td>
    </tr>
    <tr>
        <td colspan=3">
            <?php
            $aplha = 'A';
            $count = 0;
            echo '<table bgcolor="#87CEFA" class="surveyTable">';
            $model_jenis = JenisSoalan::model()->findByPk($id);
            foreach ($model_jenis->soalan as $soalan) {
                $opt = '';
                echo '<tr><td colspan="2" style="font-weight:bold;width:60%;"><br />' . ++$aplha . '. ' . $soalan->tajuk . '</td>';
                if($soalan->pilihan) {
                    $exp = explode(';', $soalan->pilihan);
                    foreach ($exp as $index => $value)
                        $opt .= "<option value='$index'>$value</option>";
                    echo '</tr><tr><td colspan="2" style="font-weight:bold;width:60%;">'.$soalan->tajuk_pilihan.' <select name="pilihan['.$soalan->id.']">'.$opt.'</select></td>';
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
                        for ($i = 0; $i < 5; $i++) {
                            $checked = false;
                            echo '<td>' . CHtml::radioButton("Survey[markah][$sub->id]", $checked, array(
                                'value' => $nilai,
                                'uncheckValue' => null,
                                'required' => TRUE,
                            )) . '</td>';
                            $nilai++;
                        }
                }
                echo '</tr>';
                $count++;
            }
            if($model_jenis->pembentangan == 1) {
                $counter = 1;
                echo '<tr><td colspan="2" style="font-weight:bold;width:60%;"><br />' . ++$aplha . '. PEMBENTANGAN KERTAS KERJA</td>';
                echo '<tr><td width="5%">' . $counter++ . '.</td><td>Tajuk Pembentangan akan dipaparkan di sini</td>';
                $nilai = 1;
                for ($j = 0; $j < 5; $j++) {
                    $checked = false;
                    echo '<td>' . CHtml::radioButton("Survey[pembentangan][$p->id]", $checked, array(
                        'value' => $nilai,
                        'uncheckValue' => null,
                        'required' => TRUE,
                    )) . '</td>';
                    $nilai++;
                }
            }
            if($model_jenis->ulasan == 1) {
                echo '<tr><td colspan="7" style="font-weight:bold"><br />' . ++$aplha . '. ULASAN</br>';
                echo CHtml::textArea('ulasan', '', array('rows' => 6, 'cols' => 80));
                echo '</td></tr>';
            }
            if($model_jenis->cadangan == 1) {
                echo '<tr><td colspan="7" style="font-weight:bold"><br />' . ++$aplha . '. CADANGAN PENAMBAHBAIKAN</br>';
                echo CHtml::textArea('cadangan', '', array('rows' => 6, 'cols' => 80));
                echo '</td></tr>';
            }
            echo '</table>'; ?>
        </td>
    </tr>
</table>
<p align="justify"><h3>Pihak kami mengucapkan terima kasih di atas keprihatinan dan maklumbalas yang pihak Tuan/Puan telah berikan.</h3></p>
<br />