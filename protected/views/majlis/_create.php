<?php
/* @var $this SurveyController */
/* @var $model Survey */
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'majlis-form',
	'enableAjaxValidation'=>false,
)); 

$this->breadcrumbs=array(
	'Surveys'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Majlis', 'url'=>array('index')),
	array('label'=>'Manage Majlis', 'url'=>array('admin')),
);
?>
<?php 
$idMajlis = Yii::app()->user->getState('id_majlis');
$model_Majlis = Majlis::model()->findByPk($idMajlis);
                    
$flag = $model_Majlis->flag_survey;
echo "<h1>Pengurusan Survey ".$model_Majlis->majlis."</h1>";



if ($flag <> 1){
    echo CHtml::button('Mulakan Survey', array('class' => 'btn_print','submit' => array('majlis/start'))); 
}
    elseif($flag == 1){ 
    echo CHtml::button('Tutup Survey', array('class' => 'btn_print','submit' => array('majlis/stop'))); 
}
$this->endWidget(); 
?>