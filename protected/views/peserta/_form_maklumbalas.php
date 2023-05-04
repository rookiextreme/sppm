<?php
/* @var $this PesertaController */
/* @var $model Peserta */
/* @var $form CActiveForm */

$arrJabatan = CHtml::listData(Jabatan::model()->getAgenciesList(), 'kod', 'keterangankod');
$arrJabatan[Jabatan::LAIN_LAIN] = "Lain-lain"; // add lain-lain to dropdownlist
$majlis = Majlis::model()->findByPk($model->id_majlis);
?> 

<div class="form wide">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'peserta-form',
	'enableAjaxValidation'=>false,
)); 
?>
	<?php echo $form->errorSummary($model, 'Ralat :'); ?>
    <br />
	<div class="row">
		<?php echo $form->labelEx($model,'nama'); ?>
		<?php echo $model->nama; ?>
	</div>
    <br />
	<div class="row">
		<?php echo $form->labelEx($model,'nokp'); ?>
		<?php echo $model->nokp; ?>
	</div>
    <br />
	<div class="row">
		<?php echo $form->labelEx($model,'organisasi'); ?>
		<?php echo $model->organisasi; ?>
	</div>
    <br />
	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $model->email; ?>
	</div>
    <br />
        <div class="row" id="status">
		<?php echo $form->labelEx($model,'status'); ?>
                <?php echo $form->dropDownList($model,'status', Peserta::model()->status_kehadiran); ?>
	</div>
        
       
    <?php echo CHtml::hiddenField('kehadiran_keluarga',$majlis->kehadiran_keluarga, array('id'=>'kehadiran_keluarga')); ?>
        
    <br />
    <div class="row" id="pengganti" >
        <h3>Sila masukkan cadangan butiran pengganti</h3>
    <div class="row">
		<?php echo $form->labelEx($model,'nama_pengganti'); ?>
		<?php echo $form->textField($model,'nama_pengganti',array('size'=>40,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email_pengganti'); ?>
		<?php echo $form->textField($model,'email_pengganti',array('size'=>40,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tel_pengganti'); ?>
		<?php echo $form->textField($model,'tel_pengganti',array('size'=>20,'maxlength'=>30)); ?>
	</div>
    </div>
    
    <div id="maklumbalas">
        <div class="row" id="tel">
		<?php echo $form->labelEx($model,'no_tel'); ?>
                <?php echo $form->textField($model,'no_tel',array('size'=>12,'maxlength'=>12)); ?>
	</div>
        <div class="row">
            <?php echo $form->labelEx($model,'tkh_checkin'); ?>
                    <?php $form->widget('ext.jui.EJuiDateTimePicker',array(
                    'model'     => $model,
                    'attribute' => 'tkh_checkin',
                    'language'=> 'en',
                    'options'   => array(
                    'dateFormat' => 'yy-mm-dd',
                    'timeFormat' => 'hh:mm:00',//'hh:mm tt' default
                    ),
                    'htmlOptions'=>array('value'=>$_POST['Peserta']['tkh_checkin']),
                )
            );
                ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model,'tkh_checkout'); ?>
                    <?php $form->widget('ext.jui.EJuiDateTimePicker',array(
                    'model'     => $model,
                    'attribute' => 'tkh_checkout',
                    'language'=> 'en',
                    'options'   => array(
                    'dateFormat' => 'yy-mm-dd',
                    'timeFormat' => 'hh:mm:00',//'hh:mm tt' default
                    ),
                    'htmlOptions'=>array('value'=>$_POST['Peserta']['tkh_checkout']),
                )
            );
                ?>
        </div>
        <div class="row">
		<?php echo $form->labelEx($model,'bilik_tambahan'); ?>
		<?php echo $form->checkBox($model,'bilik_tambahan'); ?>
        </div>
        <div class="row">
		<?php echo $form->labelEx($model,'pengangkutan_airport'); ?>
		<?php echo $form->checkBox($model,'pengangkutan_airport',array('id'=>'airport')); ?>
        </div>
        <br />
        <div id="pengangkutan">
            <div class="row">
            <?php echo $form->labelEx($model,'masa_ketibaan'); ?>
                    <?php $form->widget('ext.jui.EJuiDateTimePicker',array(
                    'model'     => $model,
                    'attribute' => 'masa_ketibaan',
                    'language'=> 'en',
                    'options'   => array(
                    'dateFormat' => 'yy-mm-dd',
                    'timeFormat' => 'hh:mm:00',//'hh:mm tt' default
                    ),
                    'htmlOptions'=>array('value'=>$_POST['Peserta']['masa_ketibaan']),
                )
            );
                ?>
            </div>
            <div class="row">
            <?php echo $form->labelEx($model,'masa_berlepas'); ?>
                    <?php $form->widget('ext.jui.EJuiDateTimePicker',array(
                    'model'     => $model,
                    'attribute' => 'masa_berlepas',
                    'language'=> 'en',
                    'options'   => array(
                    'dateFormat' => 'yy-mm-dd',
                    'timeFormat' => 'hh:mm:00',//'hh:mm tt' default
                    ),
                    'htmlOptions'=>array('value'=>$_POST['Peserta']['masa_berlepas']),
                )
            );
                ?>
            </div>
        </div>
        <div id="keluarga" >
    <table id="table-list-keluarga" class="tblsytle1">
        <tr><td colspan="3" ><h3 style="text-align:left">Sila masukkan maklumat keluarga</h3></td></tr>
            <tr>
                 <th>Nama</th>
                 <th>Umur</th>
                 <th>Jantina</th>
                 <th>Hubungan</th>
            </tr>
            <tr>
            <td><?php echo CHtml::textField('nama[]','',array('rows'=>1, 'cols'=>50)); ?></td>
            <td><?php echo CHtml::textField('umur[]','',array('rows'=>1, 'cols'=>2)); ?></td>
            <td><?php echo CHtml::dropDownList('jantina[]','',Peserta::$jantinaArr); ?></td>
            <td><?php echo CHtml::dropDownList('hubungan[]','',Peserta::$hubunganArr); ?></td>
            </tr>
    </table>
    <?php echo CHtml::button("+ Keluarga",array('title'=>"Tambah Keluarga",'id'=>'tambah-keluarga','class' => 'btn_print ui-corner-all'));?>
    </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Hantar', array('class' => 'btn_general')); ?>
    </div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<?php 
Yii::app()->clientScript->registerScript(
    'drop-down-load','$(document).ready(function() {
        checkStatus();
        checkAirport();
        $("#Peserta_status").change(function() {
            checkStatus();
        });

        $("#tambah-keluarga").click(function(){
            $("#table-list-keluarga tr:last").clone(true).insertAfter("#table-list-keluarga tr:last");
            return false;
        });
        
        $("#airport").live("click", function(){
            checkAirport();
        });
    });
    
    function checkStatus() {
        if($("#kehadiran_keluarga").val() == 1) {
            $("#keluarga").show();
        } else {
            $("#keluarga").hide();
        }
        if($("#Peserta_status").val() == 2 ) {
            $("#pengganti").show();
            $("#keluarga").hide();
        } else if($("#Peserta_status").val() == 0 ) {
            $("#keluarga").hide();
            $("#maklumbalas").hide();
        } else {
            $("#pengganti").hide();
            $("#maklumbalas").show();
        }
    }
    
        function checkAirport() {
            var id = parseInt($("#airport").val(), 10);
            if($("#airport").is(":checked")) {
                $("#pengangkutan").show();
            } else {
                $("#pengangkutan").hide();
            }
        }'
); 
