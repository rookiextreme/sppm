<?php
/* @var $this SurveyController */
/* @var $model Survey */
/* @var $form CActiveForm */
?>

<?php
$Pengguna = Peserta::model()->findByPk($id_pengguna);
$Majlis = Majlis::model()->findByPk($Pengguna->id_majlis);
?>

<?php if ($Majlis) { ?>

    <div class="form">
        <?php
        $form = $this->beginWidget('CActiveForm', array(
            'id' => 'survey-form',
            'enableAjaxValidation' => false,
        ));
        ?>
    <?php echo $form->errorSummary($model); ?><td class="input"></td>
            <p align="justify"><h3>Pihak kami mengucapkan terima kasih di atas keprihatinan dan maklumbalas yang pihak Tuan/Puan telah berikan.</h3></p>
            <br><div class="row buttons">
    <?php // echo $form->hiddenField($model, 'id_pengguna',array('value'=>base64_decode(trim($_GET['id_pengguna'], 'jTVZHCdTCAaxTQBFqZG7gnS3'))))?>
    <?php echo CHtml::submitButton('Hantar', array('class' => 'btn_search ui-corner-all')); ?>
    <?php echo CHtml::resetButton('Reset', array('class' => 'btn_print ui-corner-all')); ?>
            </div>
            <br>
            <table><tr>
                <td><img src="images/footer.jpg"></td>
                </tr>
            </table>
    <?php $this->endWidget(); ?>
    </div><!-- form -->
<?php } else { ?> 
    Majlis tidak wujud.
<?php } ?>